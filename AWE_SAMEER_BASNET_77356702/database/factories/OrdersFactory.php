<?php

namespace Database\Factories;

use App\Models\Users;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrdersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Users::factory(), // Generate a user using the User factory
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'canceled']),
            'total' => $this->faker->randomFloat(2, 10, 5000), // Total between 10 and 5000
            'session_id' => $this->faker->optional()->uuid(), // Optional session ID
        ];
    }
}
