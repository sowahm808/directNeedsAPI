<?php

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    public function definition()
    {
        return [
            // You can either create new records or use existing ones. Here we're generating new ones.
            'user_id'        => User::factory(),
            'application_id' => Application::factory(),
            'action'         => $this->faker->sentence,
            'details'        => $this->faker->paragraph,
        ];
    }
}
