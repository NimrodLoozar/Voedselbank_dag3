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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Ensure to hash the password
        ]);

        // Call the seeders
        $this->call([
            ContactSeeder::class,
            LeverancierSeeder::class,
            ContactPerLeverancierSeeder::class,
            CategorieSeeder::class, // Moet vóór ProductSeeder!
            ProductSeeder::class, // Moet vóór ProductPerLeverancierSeeder!
            ProductPerLeverancierSeeder::class,
        ]);
    }
}
