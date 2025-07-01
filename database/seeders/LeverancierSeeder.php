<?php

namespace Database\Seeders;

use App\Models\Leverancier;
use Illuminate\Database\Seeder;

class LeverancierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leveranciers = [
            ['id' => 1, 'naam' => 'Albert Heijn', 'contact_persoon' => 'Ruud ter Weijden', 'leverancier_nummer' => 'L0001', 'leverancier_type' => 'Bedrijf'],
            ['id' => 2, 'naam' => 'Albertus Kerk', 'contact_persoon' => 'Leo Pastoor', 'leverancier_nummer' => 'L0002', 'leverancier_type' => 'Instelling'],
            ['id' => 3, 'naam' => 'Gemeente Utrecht', 'contact_persoon' => 'Mohammed Yazidi', 'leverancier_nummer' => 'L0003', 'leverancier_type' => 'Overheid'],
            ['id' => 4, 'naam' => 'Boerderij Meerhoven', 'contact_persoon' => 'Bertus van Driel', 'leverancier_nummer' => 'L0004', 'leverancier_type' => 'Particulier'],
            ['id' => 5, 'naam' => 'Jan van der Heijden', 'contact_persoon' => 'Jan van der Heijden', 'leverancier_nummer' => 'L0005', 'leverancier_type' => 'Donor'],
            ['id' => 6, 'naam' => 'Vomar', 'contact_persoon' => 'Jaco Pastorius', 'leverancier_nummer' => 'L0006', 'leverancier_type' => 'Bedrijf'],
            ['id' => 7, 'naam' => 'DekaMarkt', 'contact_persoon' => 'Sil den Dollaard', 'leverancier_nummer' => 'L0007', 'leverancier_type' => 'Bedrijf'],
            ['id' => 8, 'naam' => 'Gemeente Vught', 'contact_persoon' => 'Jan Blokker', 'leverancier_nummer' => 'L0008', 'leverancier_type' => 'Overheid']
        ];

        foreach ($leveranciers as $leverancier) {
            Leverancier::create($leverancier);
        }
    }
}
