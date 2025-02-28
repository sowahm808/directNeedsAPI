<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Application;
use App\Models\ApplicationNote;
use App\Models\DiaryReminder;
use App\Models\Payment;
use App\Models\Communication;
use App\Models\ExpenseStatement;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        Schema::disableForeignKeyConstraints();

        // Clear existing data safely
        AuditLog::query()->delete();
        ExpenseStatement::query()->delete();
        Communication::query()->delete();
        Payment::query()->delete();
        DiaryReminder::query()->delete();
        ApplicationNote::query()->delete();
        Application::query()->delete();
        User::query()->delete();

        // Enable foreign key checks
        Schema::enableForeignKeyConstraints();

        // Create users by role
        $supervisors = User::factory()->count(10)->create(['role' => 'supervisor']);
        $processors = User::factory()->count(5)->create(['role' => 'processor']);
        User::factory()->count(2)->create(['role' => 'admin']);
        User::factory()->count(2)->create(['role' => 'auditor']);

        // Initialize Faker
        $faker = Faker::create();

        // Collect applications for processing
        $applications = collect();

        // Create applications for each supervisor (replacing applicant)
        foreach ($supervisors as $supervisor) {
            $appApps = Application::factory()->count(rand(1, 3))->create([
                'applicant_id' => $supervisor->id,
                'assigned_processor_id' => $processors->random()->id,
                'status' => $this->randomStatus(),
                'name' => $faker->name,
                'street_address' => $faker->streetAddress,
                'apartment' => $faker->secondaryAddress,
                'city' => $faker->city,
                'state' => $faker->state,
                'zip' => $faker->postcode,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'children_count' => $faker->numberBetween(0, 5),
                'children_details' => 'Female, 12; Male, 8', // Example static value; could be randomized
                'assistance_needed' => 'Housing Assistance, Utilities',
                'snap_benefits' => $faker->boolean,
                'circumstance_details' => $faker->paragraph,
                'essential_needs' => 'Legal Assistance, Respite Care',
                'essential_circumstances' => $faker->paragraph,
                'supporting_documents' => null
            ]);
            $applications = $applications->merge($appApps);
        }

        // For each application, seed related records.
        foreach ($applications as $application) {
            // Seed Application Notes
            ApplicationNote::factory()->count(rand(1, 3))->create([
                'application_id' => $application->id,
                'user_id' => $processors->random()->id,
            ]);

            // Seed Diary Reminders
            DiaryReminder::factory()->count(rand(1, 2))->create([
                'application_id' => $application->id,
                'user_id' => $processors->random()->id,
            ]);

            // Seed Payments
            Payment::factory()->create([
                'application_id' => $application->id,
            ]);

            // Seed Communications
            Communication::factory()->count(rand(1, 2))->create([
                'application_id' => $application->id,
            ]);

            // Seed Expense Statements
            ExpenseStatement::factory()->create([
                'application_id' => $application->id,
            ]);

            // Seed Audit Logs
            AuditLog::factory()->count(rand(1, 3))->create([
                'application_id' => $application->id,
                'user_id' => $processors->random()->id,
            ]);
        }

        $this->command->info('Database seeding completed successfully.');
    }

    /**
     * Get a random status for applications.
     * Ensures some are approved, some denied, and others in other statuses.
     */
    private function randomStatus()
    {
        $statuses = ['submitted', 'processing', 'first_contact', 'approved', 'denied', 'closed'];
        return $statuses[array_rand($statuses)];
    }
}
