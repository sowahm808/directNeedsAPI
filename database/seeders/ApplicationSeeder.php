<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Empty the applications table
        Application::truncate();

        // Enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Define possible statuses and assistance options
        $statuses = ['submitted', 'processing', 'first_contact', 'approved', 'denied', 'closed'];
        $assistanceOptions = [
            'Housing Assistance',
            'Utilities',
            'Transportation Costs',
            'Gasoline',
            'Prescriptions',
            'Emergency Food Assistance'
        ];

        // Fetch users for different roles
        $supervisors = User::where('role', 'supervisor')->get();
        $processors = User::where('role', 'processor')->get();

        // Ensure there are supervisors and processors
        if ($supervisors->isEmpty() || $processors->isEmpty()) {
            $this->command->error('Please seed users with supervisor and processor roles first.');
            return;
        }

        // Initialize Faker
        $faker = Faker::create();

        // Seed 30 applications
        for ($i = 1; $i <= 30; $i++) {
            // Randomly assign statuses with more submitted applications
            $status = $i <= 10 ? 'submitted' : Arr::random($statuses);

            // Determine assigned processor
            $assignedProcessorId = null;
            if (in_array($status, ['processing', 'approved', 'denied', 'closed'])) {
                $assignedProcessorId = $processors->random()->id;
            }

            // Create the application record
            Application::create([
                'applicant_id' => $supervisors->random()->id,
                'assigned_processor_id' => $assignedProcessorId,
                'status' => $status,
                'grant_amount' => $status === 'approved' ? $faker->randomFloat(2, 100, 10000) : null,
                'approval_date' => $status === 'approved' ? $faker->dateTimeBetween('-30 days', 'now') : null,
                'assistance_needed' => implode(', ', Arr::random($assistanceOptions, rand(1, 3))),
                'children_count' => rand(0, 5),
                'children_details' => $faker->sentence,
                'circumstance_details' => $faker->paragraph,
                'essential_needs' => 'Legal Assistance, Respite Care',
                'essential_circumstances' => $faker->paragraph,
                'snap_benefits' => rand(0, 1),
                'supporting_documents' => null,
                'name' => $faker->name,
                'street_address' => $faker->streetAddress,
                'apartment' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()
            ]);
        }

        $this->command->info('30 applications seeded successfully.');
    }
}
