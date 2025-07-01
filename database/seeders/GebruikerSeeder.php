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
            [
                'id' => 1,
                'persoon_id' => 1,
                'inlog_naam' => 'Hans',
                'gebruikersnaam' => 'hans@maaskantje.nl',
                'wachtwoord' => '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL6zKiF0i',
                'is_ingelogd' => true,
                'ingelogd' => '2024-03-13 17:03:06',
                'uitgelogd' => null
            ],
            [
                'id' => 2,
                'persoon_id' => 2,
                'inlog_naam' => 'Jan',
                'gebruikersnaam' => 'jan@maaskantje.nl',
                'wachtwoord' => '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVowCp/DL3zKiF6i',
                'is_ingelogd' => false,
                'ingelogd' => '2024-03-13 15:13:23',
                'uitgelogd' => '2024-03-13 15:23:46'
            ],
            [
                'id' => 3,
                'persoon_id' => 3,
                'inlog_naam' => 'Herman',
                'gebruikersnaam' => 'herman@maaskantje.nl',
                'wachtwoord' => '$2y$10$296RMzqzZqWENu9vyh6axed0DkfsuYkbvoI/AXVuwCp/DL9zKiF2i',
                'is_ingelogd' => true,
                'ingelogd' => '2024-06-20 12:05:20',
                'uitgelogd' => null
            ],
            [
                'id' => 4,
                'persoon_id' => 4,
                'inlog_naam' => 'Admin',
                'gebruikersnaam' => 'Admin@example.com',
                'wachtwoord' => bcrypt('Admin1234'),
                'is_ingelogd' => false,
                'ingelogd' => null,
                'uitgelogd' => null
            ]
        ];

        foreach ($gebruikers as $gebruiker) {
            Gebruiker::create($gebruiker);
        }
    }
}
