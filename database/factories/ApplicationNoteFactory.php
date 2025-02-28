<?php

namespace Database\Factories;

use App\Models\ApplicationNote;
use App\Models\Application;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationNoteFactory extends Factory
{
    protected $model = ApplicationNote::class;

    public function definition()
    {
        return [
            // If you want to associate with an existing application/user, you may override these values in your seeder.
            'application_id' => Application::factory(),
            'user_id'        => User::factory(),
            'note'           => $this->faker->paragraph,
            'note_type'      => $this->faker->randomElement(['initial', 'follow_up', 'contact', 'approval', 'other']),
        ];
    }
}
