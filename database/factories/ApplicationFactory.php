<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    protected $model = Application::class;

    public function definition()
    {
        // Generate a random total grant amount for example purposes.
        $totalGrant = $this->faker->randomFloat(2, 500, 2000);

        return [
            'applicant_id' => User::inRandomOrder()->where('role', 'supervisor')->first()->id ?? User::factory(),
            'assigned_processor_id' => User::inRandomOrder()->where('role', 'processor')->first()->id ?? null,
            'status' => $this->faker->randomElement(['submitted', 'processing', 'first_contact', 'approved', 'denied', 'closed']),
            'grant_amount' => $totalGrant,
            'approval_date' => null,

            // New fields from the needs submission form:
            'name' => $this->faker->name,
            'street_address' => $this->faker->streetAddress,
            'apartment' => $this->faker->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'zip' => $this->faker->postcode,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'role' => $this->faker->randomElement(['Parent', 'Caregiver', 'Guardian', 'Other']),
            'children_count' => $this->faker->numberBetween(0, 5),
            'children_details' => $this->faker->sentence,
            'assistance_needed' => $this->faker->randomElement(['Housing Assistance', 'Utilities', 'Medical', 'Legal']),
            'snap_benefits' => $this->faker->boolean,
            'circumstance_details' => $this->faker->paragraph,
            'essential_needs' => $this->faker->randomElement(['Legal Assistance', 'Respite Care', 'Transportation', 'Food']),
            'essential_circumstances' => $this->faker->paragraph,
            'supporting_documents' => null
        ];
    }
}
