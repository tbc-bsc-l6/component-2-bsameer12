<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 1000); // Price between 10 and 1000
        $old_price = $price + $this->faker->randomFloat(2, 5, 50); // Old price higher than current price

        return [
            'name' => $this->faker->unique()->words(3, true), // Product name
            'brief_description' => $this->faker->sentence(), // Short description
            'description' => $this->faker->paragraph(), // Detailed description
            'price' => $price, // Current price
            'old_price' => $old_price, // Old price
            'SKU' => $this->faker->unique()->bothify('SKU-####'), // Unique SKU
            'stock_status' => $this->faker->randomElement(['instock', 'outstock']), // Stock status
            'quantity' => $this->faker->numberBetween(1, 100), // Quantity between 1 and 100
            'image' => $this->faker->imageUrl(640, 480, 'products', true), // Single image URL
            'images' => json_encode([
                $this->faker->imageUrl(640, 480, 'products', true),
                $this->faker->imageUrl(640, 480, 'products', true),
            ]), // Multiple images encoded as JSON
            
        ];
    }
}
