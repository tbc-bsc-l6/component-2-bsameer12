<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->value('id'),
            'subtotal' => $this->faker->randomFloat(2, 50, 1000), // Subtotal between 50 and 1000
            'discount' => $this->faker->optional(0.3, 0)->randomFloat(2, 5, 100), // 30% chance of discount
            'tax' => $this->faker->randomFloat(2, 5, 50), // Random tax between 5 and 50
            'total' => function (array $attributes) {
                return $attributes['subtotal'] - $attributes['discount'] + $attributes['tax'];
            },
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'locality' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'province' => $this->faker->state(),
            'district' => $this->faker->citySuffix(),
            'landmark' => $this->faker->optional()->secondaryAddress(),
            'zip' => $this->faker->postcode(),
            'type' => $this->faker->randomElement(['home', 'office']),
            'status' => $this->faker->randomElement(['ordered', 'delivered', 'canceled']),
            'is_shipping_different' => $this->faker->boolean(20), // 20% chance
            'delivered_date' => $this->faker->optional(0.5)->dateTimeBetween('-1 month', 'now'), // 50% chance
            'canceled_date' => $this->faker->optional(0.1)->dateTimeBetween('-1 month', 'now'), // 10% chance
        ];
    }
}

