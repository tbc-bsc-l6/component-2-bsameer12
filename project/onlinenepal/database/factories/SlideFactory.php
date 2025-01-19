<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Slide>
 */
class SlideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tagline' => $this->faker->catchPhrase(), // Generates a catchy tagline
            'title' => $this->faker->sentence(3), // Generates a short title
            'subtitle' => $this->faker->sentence(5), // Generates a descriptive subtitle
            'link' => $this->faker->url(), // Generates a valid URL
            'image' => $this->faker->imageUrl(1920, 1080, 'slides', true, 'Slide Image'), // Generates a realistic image URL
            'status' => $this->faker->randomElement(['active', 'inactive']), // Randomly sets status
        ];
    }
}

