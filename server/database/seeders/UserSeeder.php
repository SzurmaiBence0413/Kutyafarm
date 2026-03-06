<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '123',
            'role' => User::ROLE_ADMIN,
        ]);

        // 30 uj user alap szerepkorrel (role = 3, orokbefogado), Faker nevekkel
        for ($i = 1; $i <= 30; $i++) {
            User::factory()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => '123',
                'role' => User::ROLE_ADOPTER,
            ]);
        }
    }
}
