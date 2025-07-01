<?php

namespace Database\Seeders;

use App\Models\Eetwens;
use Illuminate\Database\Seeder;

class EetwensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $eetwensen = [
            ['id' => 1, 'naam' => 'GeenVarken', 'omschrijving' => 'Geen Varkensvlees'],
            ['id' => 2, 'naam' => 'Veganistisch', 'omschrijving' => 'Geen zuivelproducten en vlees'],
            ['id' => 3, 'naam' => 'Vegetarisch', 'omschrijving' => 'Geen vlees'],
            ['id' => 4, 'naam' => 'Omnivoor', 'omschrijving' => 'Geen beperkingen']
        ];

        foreach ($eetwensen as $eetwens) {
            Eetwens::create($eetwens);
        }
    }
}
