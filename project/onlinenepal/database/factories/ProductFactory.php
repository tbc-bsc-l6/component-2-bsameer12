<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'short_description' => $this->faker->optional()->sentence(10),
            'description' => $this->faker->paragraphs(3, true),
            'regular_price' => $this->faker->randomFloat(2, 10, 500),
            'sales_price' => $this->faker->optional(0.5)->randomFloat(2, 5, 400), // 50% chance of having a sales price
            'SKU' => strtoupper($this->faker->unique()->lexify('??????')),
            'stock_status' => $this->faker->randomElement(['instock', 'outofstock']),
            'featured' => $this->faker->boolean(20), // 20% chance of being featured
            'quantity' => $this->faker->numberBetween(0, 100),
            'image' => $this->faker->optional()->imageUrl(640, 480, 'products', true, $name),
            'images' => json_encode([
                $this->faker->imageUrl(640, 480, 'products', true, $name),
                $this->faker->imageUrl(640, 480, 'products', true, $name),
            ]),
            'category_id' => Category::inRandomOrder()->value('id'),
            'brand_id' => Brand::inRandomOrder()->value('id'),
        ];
    }
}
