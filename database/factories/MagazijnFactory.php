<?php

namespace Database\Factories;

use App\Models\Magazijn;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Magazijn>
 */
class MagazijnFactory extends Factory
{
    protected $model = Magazijn::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $ontvangstdatum = $this->faker->dateTimeBetween('-6 months', 'now');

        return [
            'ontvangstdatum' => $ontvangstdatum,
            'uitleveringsdatum' => $this->faker->optional(0.3)->dateTimeBetween($ontvangstdatum, 'now'),
            'verpakkings_eenheid' => $this->faker->randomElement(['1 kg', '2 kg', '5 kg', '1 stuk', '6 stuks', '250 g', '1 liter']),
            'aantal' => $this->faker->numberBetween(10, 300)
        ];
    }
}
