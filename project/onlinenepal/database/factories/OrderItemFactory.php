<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::inRandomOrder()->value('id'), // Associate with an existing product
            'order_id' => Order::inRandomOrder()->value('id'), // Associate with an existing order
            'price' => $this->faker->randomFloat(2, 5, 500), // Price between 5 and 500
            'quantity' => $this->faker->numberBetween(1, 10), // Quantity between 1 and 10
            'options' => json_encode([ // Use native json_encode() function
                'color' => $this->faker->optional()->colorName(),
            ]),
            'rstatus' => $this->faker->boolean(10), // 10% chance of being true
        ];
    }
}

