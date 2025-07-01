<?php

namespace Database\Seeders;

use App\Models\Magazijn;
use Illuminate\Database\Seeder;

class MagazijnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $magazijnen = [
            ['id' => 1, 'ontvangstdatum' => '2024-05-12', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '5 kg', 'aantal' => 20],
            ['id' => 2, 'ontvangstdatum' => '2024-05-26', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '2.5 kg', 'aantal' => 40],
            ['id' => 3, 'ontvangstdatum' => '2024-04-02', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 kg', 'aantal' => 30],
            ['id' => 4, 'ontvangstdatum' => '2024-05-16', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1.5 kg', 'aantal' => 25],
            ['id' => 5, 'ontvangstdatum' => '2024-05-23', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '4 stuks', 'aantal' => 75],
            ['id' => 6, 'ontvangstdatum' => '2024-03-12', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 kg/tros', 'aantal' => 60],
            ['id' => 7, 'ontvangstdatum' => '2024-03-19', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '2 kg/tros', 'aantal' => 200],
            ['id' => 8, 'ontvangstdatum' => '2024-06-19', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '200 g', 'aantal' => 45],
            ['id' => 9, 'ontvangstdatum' => '2024-07-23', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '100 g', 'aantal' => 60],
            ['id' => 10, 'ontvangstdatum' => '2024-07-23', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 liter', 'aantal' => 120],
            ['id' => 11, 'ontvangstdatum' => '2024-06-02', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '250 g', 'aantal' => 80],
            ['id' => 12, 'ontvangstdatum' => '2024-01-04', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '6 stuks', 'aantal' => 120],
            ['id' => 13, 'ontvangstdatum' => '2024-04-07', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '800 g', 'aantal' => 220],
            ['id' => 14, 'ontvangstdatum' => '2024-04-04', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 stuk', 'aantal' => 130],
            ['id' => 15, 'ontvangstdatum' => '2024-04-28', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '150 ml', 'aantal' => 72],
            ['id' => 16, 'ontvangstdatum' => '2024-04-19', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 l', 'aantal' => 12],
            ['id' => 17, 'ontvangstdatum' => '2024-04-23', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '250 g', 'aantal' => 300],
            ['id' => 18, 'ontvangstdatum' => '2024-03-02', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '25 zakjes', 'aantal' => 280],
            ['id' => 19, 'ontvangstdatum' => '2024-04-16', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '500 g', 'aantal' => 330],
            ['id' => 20, 'ontvangstdatum' => '2024-04-25', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 kg', 'aantal' => 34],
            ['id' => 21, 'ontvangstdatum' => '2024-04-13', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '50 g', 'aantal' => 23],
            ['id' => 22, 'ontvangstdatum' => '2024-04-23', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 l', 'aantal' => 46],
            ['id' => 23, 'ontvangstdatum' => '2024-04-21', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '250 ml', 'aantal' => 98],
            ['id' => 24, 'ontvangstdatum' => '2024-04-30', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 potje', 'aantal' => 56],
            ['id' => 25, 'ontvangstdatum' => '2024-04-27', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '1 l', 'aantal' => 210],
            ['id' => 26, 'ontvangstdatum' => '2024-04-01', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '4 stuks', 'aantal' => 24],
            ['id' => 27, 'ontvangstdatum' => '2024-04-07', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '300 g', 'aantal' => 87],
            ['id' => 28, 'ontvangstdatum' => '2024-04-22', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '200 g', 'aantal' => 230],
            ['id' => 29, 'ontvangstdatum' => '2024-04-21', 'uitleveringsdatum' => null, 'verpakkings_eenheid' => '80 g', 'aantal' => 30]
        ];

        foreach ($magazijnen as $magazijn) {
            Magazijn::create($magazijn);
        }
    }
}
