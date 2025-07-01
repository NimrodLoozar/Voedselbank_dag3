<?php

namespace Database\Factories;

use App\Models\Voedselpakket;
use App\Models\Gezin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voedselpakket>
 */
class VoedselpakketFactory extends Factory
{
    protected $model = Voedselpakket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $statussen = ['Uitgereikt', 'NietUitgereikt', 'NietMeerIngeschreven'];
        $datumSamenstelling = $this->faker->dateTimeBetween('-3 months', 'now');

        return [
            'gezin_id' => Gezin::factory(),
            'pakket_nummer' => $this->faker->numberBetween(1, 1000),
            'datum_samenstelling' => $datumSamenstelling,
            'datum_uitgifte' => $this->faker->optional(0.7)->dateTimeBetween($datumSamenstelling, 'now'),
            'status' => $this->faker->randomElement($statussen)
        ];
    }
}
