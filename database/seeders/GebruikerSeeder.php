<?php

namespace Database\Seeders;

use App\Models\Gebruiker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GebruikerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gebruikers = [
            ['id' => 1, 'persoon_id' => 1, 'inlog_naam' => 'hans', 'gebruikersnaam' => 'hans@voedselbank.nl', 'wachtwoord' => Hash::make('password123'), 'is_ingelogd' => false, 'ingelogd' => null, 'uitgelogd' => null],
            ['id' => 2, 'persoon_id' => 2, 'inlog_naam' => 'jan', 'gebruikersnaam' => 'jan@voedselbank.nl', 'wachtwoord' => Hash::make('password123'), 'is_ingelogd' => false, 'ingelogd' => null, 'uitgelogd' => null],
            ['id' => 3, 'persoon_id' => 3, 'inlog_naam' => 'herman', 'gebruikersnaam' => 'herman@voedselbank.nl', 'wachtwoord' => Hash::make('password123'), 'is_ingelogd' => false, 'ingelogd' => null, 'uitgelogd' => null]
        ];

        foreach ($gebruikers as $gebruiker) {
            Gebruiker::create($gebruiker);
        }
    }
}
