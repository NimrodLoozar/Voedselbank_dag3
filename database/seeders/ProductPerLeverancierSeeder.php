<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPerLeverancierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productPerLeverancier = [
            ['id' => 1, 'leverancier_id' => 4, 'product_id' => 1, 'datum_aangeleverd' => '2024-04-12', 'datum_eerst_volgende_levering' => '2024-05-12'],
            ['id' => 2, 'leverancier_id' => 4, 'product_id' => 2, 'datum_aangeleverd' => '2024-03-02', 'datum_eerst_volgende_levering' => '2024-04-02'],
            ['id' => 3, 'leverancier_id' => 2, 'product_id' => 3, 'datum_aangeleverd' => '2024-07-16', 'datum_eerst_volgende_levering' => '2024-08-16'],
            ['id' => 4, 'leverancier_id' => 1, 'product_id' => 4, 'datum_aangeleverd' => '2024-02-12', 'datum_eerst_volgende_levering' => '2024-03-12'],
            ['id' => 5, 'leverancier_id' => 4, 'product_id' => 5, 'datum_aangeleverd' => '2024-05-19', 'datum_eerst_volgende_levering' => '2024-06-19'],
            ['id' => 6, 'leverancier_id' => 1, 'product_id' => 6, 'datum_aangeleverd' => '2024-06-23', 'datum_eerst_volgende_levering' => '2024-07-23'],
            ['id' => 7, 'leverancier_id' => 4, 'product_id' => 7, 'datum_aangeleverd' => '2024-06-20', 'datum_eerst_volgende_levering' => '2024-07-20'],
            ['id' => 8, 'leverancier_id' => 4, 'product_id' => 8, 'datum_aangeleverd' => '2024-05-02', 'datum_eerst_volgende_levering' => '2024-06-02'],
            ['id' => 9, 'leverancier_id' => 4, 'product_id' => 9, 'datum_aangeleverd' => '2022-12-04', 'datum_eerst_volgende_levering' => '2024-01-04'],
            ['id' => 10, 'leverancier_id' => 3, 'product_id' => 10, 'datum_aangeleverd' => '2024-03-07', 'datum_eerst_volgende_levering' => '2024-04-07'],
            ['id' => 11, 'leverancier_id' => 3, 'product_id' => 11, 'datum_aangeleverd' => '2024-02-04', 'datum_eerst_volgende_levering' => '2024-03-04'],
            ['id' => 12, 'leverancier_id' => 3, 'product_id' => 12, 'datum_aangeleverd' => '2024-02-28', 'datum_eerst_volgende_levering' => '2024-03-28'],
            ['id' => 13, 'leverancier_id' => 3, 'product_id' => 13, 'datum_aangeleverd' => '2024-03-19', 'datum_eerst_volgende_levering' => '2024-04-19'],
            ['id' => 14, 'leverancier_id' => 2, 'product_id' => 14, 'datum_aangeleverd' => '2024-03-23', 'datum_eerst_volgende_levering' => '2024-04-23'],
            ['id' => 15, 'leverancier_id' => 2, 'product_id' => 15, 'datum_aangeleverd' => '2024-02-02', 'datum_eerst_volgende_levering' => '2024-03-02'],
            ['id' => 16, 'leverancier_id' => 1, 'product_id' => 16, 'datum_aangeleverd' => '2024-02-16', 'datum_eerst_volgende_levering' => '2024-03-16'],
            ['id' => 17, 'leverancier_id' => 1, 'product_id' => 17, 'datum_aangeleverd' => '2024-03-25', 'datum_eerst_volgende_levering' => '2024-04-25'],
            ['id' => 18, 'leverancier_id' => 1, 'product_id' => 18, 'datum_aangeleverd' => '2024-03-13', 'datum_eerst_volgende_levering' => '2024-04-13'],
            ['id' => 19, 'leverancier_id' => 1, 'product_id' => 19, 'datum_aangeleverd' => '2024-03-23', 'datum_eerst_volgende_levering' => '2024-04-23'],
            ['id' => 20, 'leverancier_id' => 4, 'product_id' => 20, 'datum_aangeleverd' => '2024-02-21', 'datum_eerst_volgende_levering' => '2024-03-21'],
            ['id' => 21, 'leverancier_id' => 2, 'product_id' => 21, 'datum_aangeleverd' => '2024-03-31', 'datum_eerst_volgende_levering' => '2024-04-30'],
            ['id' => 22, 'leverancier_id' => 1, 'product_id' => 22, 'datum_aangeleverd' => '2024-03-27', 'datum_eerst_volgende_levering' => '2024-04-27'],
            ['id' => 23, 'leverancier_id' => 3, 'product_id' => 23, 'datum_aangeleverd' => '2024-04-11', 'datum_eerst_volgende_levering' => '2024-04-18'],
            ['id' => 24, 'leverancier_id' => 3, 'product_id' => 24, 'datum_aangeleverd' => '2024-04-07', 'datum_eerst_volgende_levering' => '2024-04-14'],
            ['id' => 25, 'leverancier_id' => 1, 'product_id' => 25, 'datum_aangeleverd' => '2024-05-07', 'datum_eerst_volgende_levering' => '2024-05-14'],
            ['id' => 26, 'leverancier_id' => 2, 'product_id' => 26, 'datum_aangeleverd' => '2024-05-05', 'datum_eerst_volgende_levering' => '2024-05-12']
        ];

        foreach ($productPerLeverancier as $relatie) {
            DB::table('product_per_leverancier')->insert([
                'leverancier_id' => $relatie['leverancier_id'],
                'product_id' => $relatie['product_id'],
                'datum_aangeleverd' => $relatie['datum_aangeleverd'],
                'datum_eerst_volgende_levering' => $relatie['datum_eerst_volgende_levering'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
