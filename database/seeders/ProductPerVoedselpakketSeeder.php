<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPerVoedselpakketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productPerVoedselpakket = [
            ['id' => 1, 'voedselpakket_id' => 1, 'product_id' => 7, 'aantal_product_eenheden' => 1],
            ['id' => 2, 'voedselpakket_id' => 1, 'product_id' => 8, 'aantal_product_eenheden' => 2],
            ['id' => 3, 'voedselpakket_id' => 1, 'product_id' => 9, 'aantal_product_eenheden' => 1],
            ['id' => 4, 'voedselpakket_id' => 2, 'product_id' => 12, 'aantal_product_eenheden' => 1],
            ['id' => 5, 'voedselpakket_id' => 2, 'product_id' => 13, 'aantal_product_eenheden' => 2],
            ['id' => 6, 'voedselpakket_id' => 2, 'product_id' => 14, 'aantal_product_eenheden' => 1],
            ['id' => 7, 'voedselpakket_id' => 3, 'product_id' => 3, 'aantal_product_eenheden' => 1],
            ['id' => 8, 'voedselpakket_id' => 3, 'product_id' => 4, 'aantal_product_eenheden' => 1],
            ['id' => 9, 'voedselpakket_id' => 4, 'product_id' => 20, 'aantal_product_eenheden' => 1],
            ['id' => 10, 'voedselpakket_id' => 4, 'product_id' => 19, 'aantal_product_eenheden' => 1],
            ['id' => 11, 'voedselpakket_id' => 4, 'product_id' => 21, 'aantal_product_eenheden' => 1],
            ['id' => 12, 'voedselpakket_id' => 5, 'product_id' => 24, 'aantal_product_eenheden' => 1],
            ['id' => 13, 'voedselpakket_id' => 5, 'product_id' => 25, 'aantal_product_eenheden' => 1],
            ['id' => 14, 'voedselpakket_id' => 5, 'product_id' => 26, 'aantal_product_eenheden' => 1],
            ['id' => 15, 'voedselpakket_id' => 6, 'product_id' => 26, 'aantal_product_eenheden' => 1]
        ];

        foreach ($productPerVoedselpakket as $relatie) {
            DB::table('product_per_voedselpakket')->insert([
                'voedselpakket_id' => $relatie['voedselpakket_id'],
                'product_id' => $relatie['product_id'],
                'aantal_product_eenheden' => $relatie['aantal_product_eenheden'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
