<?php

namespace Database\Factories;

use App\Models\Leverancier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Leverancier>
 */
class LeverancierFactory extends Factory
{
    protected $model = Leverancier::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $types = ['Bedrijf', 'Instelling', 'Overheid', 'Particulier', 'Donor'];

        return [
            'naam' => $this->faker->company,
            'contact_persoon' => $this->faker->name,
            'leverancier_nummer' => 'L' . str_pad($this->faker->unique()->numberBetween(1, 9999), 4, '0', STR_PAD_LEFT),
            'leverancier_type' => $this->faker->randomElement($types)
        ];
    }
}
