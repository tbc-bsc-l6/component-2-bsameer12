<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'locality' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'district' => $this->faker->citySuffix(),
            'country' => $this->faker->country(),
            'landmark' => $this->faker->optional()->secondaryAddress(),
            'zip' => $this->faker->postcode(),
            'type' => $this->faker->randomElement(['home', 'office']),
            'isdefault' => $this->faker->boolean(20), // 20% chance of being default
        ];
    }
}
