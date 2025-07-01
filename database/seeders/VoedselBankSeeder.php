<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\AllergieSeeder;
use Database\Seeders\RolSeeder;
use Database\Seeders\CategorieSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\EetwensSeeder;
use Database\Seeders\GezinSeeder;
use Database\Seeders\LeverancierSeeder;
use Database\Seeders\PersoonSeeder;
use Database\Seeders\GebruikerSeeder;
use Database\Seeders\MagazijnSeeder;
use Database\Seeders\ProductSeeder;

class VoedselbankSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
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
