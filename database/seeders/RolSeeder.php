<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rollen = [
            ['id' => 1, 'naam' => 'Manager'],
            ['id' => 2, 'naam' => 'Medewerker'],
            ['id' => 3, 'naam' => 'Vrijwilliger'],
            ['id' => 4, 'naam' => 'Admin']
        ];

        foreach ($rollen as $rol) {
            Rol::create($rol);
        }
    }
}
