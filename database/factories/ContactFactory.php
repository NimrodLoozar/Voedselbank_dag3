<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    protected $model = Contact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'straat' => $this->faker->streetName,
            'huisnummer' => $this->faker->buildingNumber,
            'toevoeging' => $this->faker->optional()->randomElement(['A', 'B', 'Bis', null]),
            'postcode' => $this->faker->postcode,
            'woonplaats' => $this->faker->city,
            'email' => $this->faker->unique()->safeEmail,
            'mobiel' => $this->faker->phoneNumber
        ];
    }
}
