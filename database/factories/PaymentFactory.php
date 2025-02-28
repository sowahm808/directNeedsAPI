<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Application;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition()
    {
        return [
            'application_id' => Application::factory(),
            'amount'         => $this->faker->randomFloat(2, 100, 1000),
            'payment_date'   => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'recipient_type' => $this->faker->randomElement(['provider', 'applicant']),
            'transaction_id' => $this->faker->uuid,
            'status'         => $this->faker->randomElement(['pending', 'completed', 'failed']),
        ];
    }
}
