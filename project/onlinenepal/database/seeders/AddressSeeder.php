<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Address;
use App\Models\User;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch 5 unique user IDs where usertype is 'user'
        $userIds = User::where('usertype', 'user')->pluck('id')->shuffle()->take(5);

        // Ensure there are enough users with usertype 'user'
        if ($userIds->count() < 5) {
            throw new \Exception('Not enough users with usertype "user" to assign unique addresses. Please seed more users.');
        }

        // Generate 5 addresses with unique user IDs
        foreach ($userIds as $userId) {
            Address::factory()->create([
                'user_id' => $userId,
            ]);
        }
    }
}
