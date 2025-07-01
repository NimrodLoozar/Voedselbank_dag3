<?php

namespace Database\Factories;

use App\Models\Gezin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gezin>
 */
class GezinFactory extends Factory
{
    protected $model = Gezin::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $aantalVolwassenen = $this->faker->numberBetween(1, 2);
        $aantalKinderen = $this->faker->numberBetween(0, 3);
        $aantalBabys = $this->faker->numberBetween(0, 2);
        $totaalAantal = $aantalVolwassenen + $aantalKinderen + $aantalBabys;

        return [
            'naam' => $this->faker->lastName . 'Gezin',
            'code' => 'G' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'omschrijving' => $this->faker->randomElement(['Bijstandsgezin', 'AlleenGaande', 'Werkloosheidsgezin']),
            'aantal_volwassenen' => $aantalVolwassenen,
            'aantal_kinderen' => $aantalKinderen,
            'aantal_babys' => $aantalBabys,
            'totaal_aantal_personen' => $totaalAantal
        ];
    }
}
