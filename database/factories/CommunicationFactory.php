<?php

namespace Database\Factories;

use App\Models\Communication;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommunicationFactory extends Factory
{
    protected $model = Communication::class;

    public function definition()
    {
        return [
            'application_id' => Application::factory(),
            'type'           => $this->faker->randomElement(['approval_letter', 'state_resources', 'partnerships']),
            'subject'        => $this->faker->sentence,
            'message'        => $this->faker->paragraph,
            'sent_date'      => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
