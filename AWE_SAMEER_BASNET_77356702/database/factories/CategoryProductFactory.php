<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;


class CategoryProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return 
        [];
    }

    /**
     * Attach one random category to each product.
     */
    public function configure()
    {
        return $this->afterCreating(function () {
            $categories = Categories::all();
            $products = Products::all();

            foreach ($products as $product) {
                // Attach only one random category to each product
                $product->categories()->attach(
                    $categories->random(1)->pluck('id')->first()
                );
            }
        });
    }
}
