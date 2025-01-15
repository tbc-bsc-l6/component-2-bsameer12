<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a specific user with admin privileges
        User::factory()->create([
            'name' => 'Sameer Basnet',
            'email' => 'bsameer22@tbc.edu.np',
            'password' => bcrypt('Reemas@2060BS'), // Hash the password
            'is_admin' => true, // Add this field in your User model migration if not already present
        ]);

        User::factory()->count(10)->create(); // Create 10 fake users
    }
}
