<?php

namespace Database\Factories;

use App\Models\Allergie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Allergie>
 */
class AllergieFactory extends Factory
{
    protected $model = Allergie::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $allergies = [
            ['naam' => 'Gluten', 'omschrijving' => 'Allergisch voor gluten', 'anafylactisch_risico' => 'zeerlaag'],
            ['naam' => 'Pindas', 'omschrijving' => 'Allergisch voor pindas', 'anafylactisch_risico' => 'hoog'],
            ['naam' => 'Schaaldieren', 'omschrijving' => 'Allergisch voor schaaldieren', 'anafylactisch_risico' => 'redelijk_hoog'],
            ['naam' => 'Hazelnoten', 'omschrijving' => 'Allergisch voor hazelnoten', 'anafylactisch_risico' => 'laag'],
            ['naam' => 'Lactose', 'omschrijving' => 'Allergisch voor lactose', 'anafylactisch_risico' => 'zeerlaag'],
            ['naam' => 'Soja', 'omschrijving' => 'Allergisch voor soja', 'anafylactisch_risico' => 'zeerlaag']
        ];

        $allergie = $this->faker->randomElement($allergies);

        return [
            'naam' => $allergie['naam'],
            'omschrijving' => $allergie['omschrijving'],
            'anafylactisch_risico' => $allergie['anafylactisch_risico']
        ];
    }
}
