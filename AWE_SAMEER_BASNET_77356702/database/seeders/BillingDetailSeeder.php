<?php

namespace Database\Seeders;

use App\Models\BillingDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BillingDetail::factory()->count(50)->create();
    }
}
