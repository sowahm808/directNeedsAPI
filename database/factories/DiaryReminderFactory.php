<?php

namespace Database\Factories;

use App\Models\DiaryReminder;
use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiaryReminderFactory extends Factory
{
    protected $model = DiaryReminder::class;

    public function definition()
    {
        return [
            'application_id' => Application::factory(),
            'user_id'        => User::factory(),
            'reminder_date'  => $this->faker->dateTimeBetween('now', '+1 month'),
            'description'    => $this->faker->sentence,
            'status'         => $this->faker->randomElement(['pending', 'completed']),
        ];
    }
}
