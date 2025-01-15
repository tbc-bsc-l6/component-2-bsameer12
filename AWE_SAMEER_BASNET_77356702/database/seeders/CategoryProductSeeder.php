<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create categories
        Category::factory(10)->create();

        // Create products and associate each with one category
        Product::factory(50)->create()->each(function ($product) {
            $product->categories()->attach(
                Category::inRandomOrder()->first()->id
            );
        });
    }
}
