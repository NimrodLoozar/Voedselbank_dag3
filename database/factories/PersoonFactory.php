<?php

namespace Database\Factories;

use App\Models\Persoon;
use App\Models\Gezin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persoon>
 */
class PersoonFactory extends Factory
{
    protected $model = Persoon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $types = ['Manager', 'Medewerker', 'Vrijwilliger', 'Klant'];

        return [
            'gezin_id' => $this->faker->optional(0.8)->randomElement(Gezin::pluck('id')->toArray()),
            'voornaam' => $this->faker->firstName,
            'tussenvoegsel' => $this->faker->optional(0.3)->randomElement(['van', 'de', 'der', 'van der', 'den']),
            'achternaam' => $this->faker->lastName,
            'geboortedatum' => $this->faker->dateTimeBetween('-80 years', '-1 year'),
            'type_persoon' => $this->faker->randomElement($types),
            'is_vertegenwoordiger' => $this->faker->boolean(20) // 20% chance to be representative
        ];
    }
}
