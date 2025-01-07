<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
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
        Categories::factory(10)->create();

        // Create products and associate each with one category
        Products::factory(50)->create()->each(function ($product) {
            $product->categories()->attach(
                Categories::inRandomOrder()->first()->id
            );
        });
    }
}

