<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VoedselbankSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
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
