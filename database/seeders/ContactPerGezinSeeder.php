<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactPerGezinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contactPerGezin = [
            ['id' => 1, 'gezin_id' => 1, 'contact_id' => 1],
            ['id' => 2, 'gezin_id' => 2, 'contact_id' => 2],
            ['id' => 3, 'gezin_id' => 3, 'contact_id' => 3],
            ['id' => 4, 'gezin_id' => 4, 'contact_id' => 4],
            ['id' => 5, 'gezin_id' => 5, 'contact_id' => 5],
            ['id' => 6, 'gezin_id' => 6, 'contact_id' => 6]
        ];

        foreach ($contactPerGezin as $relatie) {
            DB::table('contact_per_gezin')->insert([
                'gezin_id' => $relatie['gezin_id'],
                'contact_id' => $relatie['contact_id'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
