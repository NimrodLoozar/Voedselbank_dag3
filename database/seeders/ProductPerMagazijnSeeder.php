<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPerMagazijnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productPerMagazijn = [
            ['id' => 1, 'product_id' => 1, 'magazijn_id' => 1, 'locatie' => 'Berlicum'],
            ['id' => 2, 'product_id' => 2, 'magazijn_id' => 2, 'locatie' => 'Rosmalen'],
            ['id' => 3, 'product_id' => 3, 'magazijn_id' => 3, 'locatie' => 'Berlicum'],
            ['id' => 4, 'product_id' => 4, 'magazijn_id' => 4, 'locatie' => 'Berlicum'],
            ['id' => 5, 'product_id' => 5, 'magazijn_id' => 5, 'locatie' => 'Rosmalen'],
            ['id' => 6, 'product_id' => 6, 'magazijn_id' => 6, 'locatie' => 'Berlicum'],
            ['id' => 7, 'product_id' => 7, 'magazijn_id' => 7, 'locatie' => 'Rosmalen'],
            ['id' => 8, 'product_id' => 8, 'magazijn_id' => 8, 'locatie' => 'Sint-MichelsGestel'],
            ['id' => 9, 'product_id' => 9, 'magazijn_id' => 9, 'locatie' => 'Sint-MichelsGestel'],
            ['id' => 10, 'product_id' => 10, 'magazijn_id' => 10, 'locatie' => 'Middelrode'],
            ['id' => 11, 'product_id' => 11, 'magazijn_id' => 11, 'locatie' => 'Middelrode'],
            ['id' => 12, 'product_id' => 12, 'magazijn_id' => 12, 'locatie' => 'Middelrode'],
            ['id' => 13, 'product_id' => 13, 'magazijn_id' => 13, 'locatie' => 'Schijndel'],
            ['id' => 14, 'product_id' => 14, 'magazijn_id' => 14, 'locatie' => 'Schijndel'],
            ['id' => 15, 'product_id' => 15, 'magazijn_id' => 15, 'locatie' => 'Gemonde'],
            ['id' => 16, 'product_id' => 16, 'magazijn_id' => 16, 'locatie' => 'Gemonde'],
            ['id' => 17, 'product_id' => 17, 'magazijn_id' => 17, 'locatie' => 'Gemonde'],
            ['id' => 18, 'product_id' => 18, 'magazijn_id' => 18, 'locatie' => 'Gemonde'],
            ['id' => 19, 'product_id' => 19, 'magazijn_id' => 19, 'locatie' => 'Den Bosch'],
            ['id' => 20, 'product_id' => 20, 'magazijn_id' => 20, 'locatie' => 'Den Bosch'],
            ['id' => 21, 'product_id' => 21, 'magazijn_id' => 21, 'locatie' => 'Den Bosch'],
            ['id' => 22, 'product_id' => 22, 'magazijn_id' => 22, 'locatie' => 'Heeswijk Dinther'],
            ['id' => 23, 'product_id' => 23, 'magazijn_id' => 23, 'locatie' => 'Heeswijk Dinther'],
            ['id' => 24, 'product_id' => 24, 'magazijn_id' => 24, 'locatie' => 'Heeswijk Dinther'],
            ['id' => 25, 'product_id' => 25, 'magazijn_id' => 25, 'locatie' => 'Vught'],
            ['id' => 26, 'product_id' => 26, 'magazijn_id' => 26, 'locatie' => 'Vught'],
            ['id' => 27, 'product_id' => 27, 'magazijn_id' => 27, 'locatie' => 'Vught'],
            ['id' => 28, 'product_id' => 28, 'magazijn_id' => 28, 'locatie' => 'Vught'],
            ['id' => 29, 'product_id' => 29, 'magazijn_id' => 29, 'locatie' => 'Vught']
        ];

        foreach ($productPerMagazijn as $relatie) {
            DB::table('product_per_magazijn')->insert([
                'product_id' => $relatie['product_id'],
                'magazijn_id' => $relatie['magazijn_id'],
                'locatie' => $relatie['locatie'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
