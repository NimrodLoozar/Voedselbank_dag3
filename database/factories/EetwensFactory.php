<?php

namespace Database\Factories;

use App\Models\Eetwens;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eetwens>
 */
class EetwensFactory extends Factory
{
    protected $model = Eetwens::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $eetwensen = [
            ['naam' => 'GeenVarken', 'omschrijving' => 'Geen Varkensvlees'],
            ['naam' => 'Veganistisch', 'omschrijving' => 'Geen zuivelproducten en vlees'],
            ['naam' => 'Vegetarisch', 'omschrijving' => 'Geen vlees'],
            ['naam' => 'Omnivoor', 'omschrijving' => 'Geen beperkingen']
        ];

        $eetwens = $this->faker->randomElement($eetwensen);

        return [
            'naam' => $eetwens['naam'],
            'omschrijving' => $eetwens['omschrijving']
        ];
    }
}
