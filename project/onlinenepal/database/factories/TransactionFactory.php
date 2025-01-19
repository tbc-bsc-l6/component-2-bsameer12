<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'), // Associate with an existing user
            'order_id' => Order::inRandomOrder()->value('id'), // Associate with an existing order
            'mode' => $this->faker->randomElement(['cod', 'Paypal']), // Random payment mode
            'status' => $this->faker->randomElement(['pending', 'approved', 'declined', 'refunded']), // Random status
        ];
    }
}

