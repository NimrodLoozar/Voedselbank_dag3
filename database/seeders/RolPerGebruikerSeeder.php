<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolPerGebruikerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolPerGebruiker = [
            ['id' => 1, 'gebruiker_id' => 1, 'rol_id' => 1],
            ['id' => 2, 'gebruiker_id' => 2, 'rol_id' => 2],
            ['id' => 3, 'gebruiker_id' => 3, 'rol_id' => 3]
        ];

        foreach ($rolPerGebruiker as $relatie) {
            DB::table('rol_per_gebruiker')->insert([
                'gebruiker_id' => $relatie['gebruiker_id'],
                'rol_id' => $relatie['rol_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
