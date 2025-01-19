<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'categories', true, $name),
            'parent_id' => $this->faker->optional(0.3, null)->randomDigitNotZero(), // 30% chance of having a parent category
        ];
    }
}
