<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::updateOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => 'password', 'role' => 'user', 'is_seller' => false]
        );

        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin Reincarnate', 'password' => env('ADMIN_PASSWORD', 'admin123'), 'role' => 'admin']
        );

        if (!\App\Models\Sale::query()->exists()) {
            \App\Models\Sale::query()->insert([
                [
                    'user_id' => $user->id,
                    'item_name' => 'Celana Jeans',
                    'category' => 'Pants',
                    'price' => 150000,
                    'qty' => 2,
                    'created_at' => now()->subDays(3),
                    'updated_at' => now()->subDays(3),
                ],
                [
                    'user_id' => $user->id,
                    'item_name' => 'Baju Vondutch',
                    'category' => 'Top',
                    'price' => 100000,
                    'qty' => 1,
                    'created_at' => now()->subDays(2),
                    'updated_at' => now()->subDays(2),
                ],
                [
                    'user_id' => $admin->id,
                    'item_name' => 'Jam Tangan',
                    'category' => 'Accessories',
                    'price' => 70000,
                    'qty' => 3,
                    'created_at' => now()->subDay(),
                    'updated_at' => now()->subDay(),
                ],
            ]);
        }
    }
}
