<?php

namespace Database\Seeders;

use App\Models\User;
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

        $this->call([
            AllergieSeeder::class,
            RolSeeder::class,
            CategorieSeeder::class,
            ContactSeeder::class,
            EetwensSeeder::class,
            GezinSeeder::class,
            LeverancierSeeder::class,
            // Intermediate seeders
            PersoonSeeder::class,
            GebruikerSeeder::class,
            MagazijnSeeder::class,
            ProductSeeder::class,
            VoedselpakketSeeder::class,
            // Pivot table seeders
            AllergiePerPersoonSeeder::class,
            RolPerGebruikerSeeder::class,
            EetwensPerGezinSeeder::class,
            ContactPerLeverancierSeeder::class,
            ContactPerGezinSeeder::class,
            ProductPerVoedselpakketSeeder::class,
            ProductPerLeverancierSeeder::class,
            ProductPerMagazijnSeeder::class,
        ]);
    }

}
