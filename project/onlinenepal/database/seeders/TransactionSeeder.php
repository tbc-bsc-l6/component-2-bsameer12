<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\Order;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all order IDs
        $orderIds = Order::pluck('id')->shuffle();

        // Ensure there are enough orders for transactions
        if ($orderIds->count() < 50) {
            throw new \Exception('Not enough orders to assign unique transactions. Please seed more orders.');
        }

        // Create 50 unique transactions
        foreach ($orderIds->take(50) as $orderId) {
            Transaction::factory()->create([
                'order_id' => $orderId,
                'user_id' => Order::find($orderId)->user_id, // Ensure the transaction belongs to the user who placed the order
            ]);
        }
    }
}
