<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
use Database\Seeders\VoedselpakketSeeder;
use Database\Seeders\AllergiePerPersoonSeeder;
use Database\Seeders\RolPerGebruikerSeeder;
use Database\Seeders\EetwensPerGezinSeeder;
use Database\Seeders\ContactPerLeverancierSeeder;
use Database\Seeders\ContactPerGezinSeeder;
use Database\Seeders\ProductPerVoedselpakketSeeder;
use Database\Seeders\ProductPerLeverancierSeeder;
use Database\Seeders\ProductPerMagazijnSeeder;


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


          // Create an admin user
        $adminUser = User::factory()->create([
            'name' => 'Admin',
            'email' => 'Admin@example.com',
            'password' => bcrypt('Admin1234'),
        ]);

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
