<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->bothify('??##??##')), // Generates a unique coupon code
            'type' => $this->faker->randomElement(['fixed', 'percent']),
            'value' => $this->faker->randomFloat(2, 5, 100), // Random discount value between 5 and 100
            'cart_value' => $this->faker->randomFloat(2, 20, 500), // Minimum cart value between 20 and 500
            'expiry_date' => $this->faker->optional()->dateTimeBetween('+1 day', '+1 month'),
        ];
    }
}

