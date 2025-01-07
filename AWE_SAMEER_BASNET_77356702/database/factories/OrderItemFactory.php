<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItems>
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
            'order_id' => Orders::factory(), // Generate a related order using the Order factory
            'product_id' => Products::factory(), // Generate a related product using the Product factory
            'quantity' => $this->faker->numberBetween(1, 10), // Random quantity between 1 and 10
            'price' => $this->faker->randomFloat(2, 5, 1000), // Random price between 5 and 100
        ];
    }
}
