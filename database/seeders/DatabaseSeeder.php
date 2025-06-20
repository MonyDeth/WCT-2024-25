<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::updateOrCreate(
        ['email' => 'test@example.com'], // Condition
        ['name' => 'Test User', 'password' => bcrypt('password')] // Values
        );

        $this->call([
        CategorySeeder::class,
        ProductSeeder::class,
        PaymentMethodSeeder::class,
    ]);

    }
}
