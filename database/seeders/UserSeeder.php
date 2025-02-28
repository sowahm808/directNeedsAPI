<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',  // Consistent with your ENUM
        ]);

        // Create Applicants
        User::factory()->count(5)->create([
            'role' => 'supervisor',
        ]);

        // Create Processors
        User::factory()->count(3)->create([
            'role' => 'processor',
        ]);

        // Create Auditors
        User::factory()->count(2)->create([
            'role' => 'auditor',
        ]);

        // Optional: You can create more users with different roles if needed
    }
}
