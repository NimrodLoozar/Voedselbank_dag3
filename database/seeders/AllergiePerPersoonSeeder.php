<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergiePerPersoonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergiePerPersoon = [
            ['id' => 1, 'persoon_id' => 4, 'allergie_id' => 1],
            ['id' => 2, 'persoon_id' => 5, 'allergie_id' => 2],
            ['id' => 3, 'persoon_id' => 6, 'allergie_id' => 3],
            ['id' => 4, 'persoon_id' => 7, 'allergie_id' => 4],
            ['id' => 5, 'persoon_id' => 8, 'allergie_id' => 3],
            ['id' => 6, 'persoon_id' => 9, 'allergie_id' => 2],
            ['id' => 7, 'persoon_id' => 10, 'allergie_id' => 5],
            ['id' => 8, 'persoon_id' => 12, 'allergie_id' => 2],
            ['id' => 9, 'persoon_id' => 13, 'allergie_id' => 4],
            ['id' => 10, 'persoon_id' => 14, 'allergie_id' => 1],
            ['id' => 11, 'persoon_id' => 15, 'allergie_id' => 3],
            ['id' => 12, 'persoon_id' => 16, 'allergie_id' => 5],
            ['id' => 13, 'persoon_id' => 17, 'allergie_id' => 1],
            ['id' => 14, 'persoon_id' => 17, 'allergie_id' => 2],
            ['id' => 15, 'persoon_id' => 18, 'allergie_id' => 4],
            ['id' => 16, 'persoon_id' => 19, 'allergie_id' => 4]
        ];

        foreach ($allergiePerPersoon as $relatie) {
            DB::table('allergie_per_persoon')->insert([
                'persoon_id' => $relatie['persoon_id'],
                'allergie_id' => $relatie['allergie_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
