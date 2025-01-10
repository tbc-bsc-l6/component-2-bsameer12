<?php

namespace Database\Seeders;

use App\Models\BillingDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BillingDetails::factory()->count(50)->create();
    }
}
