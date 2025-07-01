<?php

namespace Database\Factories;

use App\Models\Gebruiker;
use App\Models\Persoon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gebruiker>
 */
class GebruikerFactory extends Factory
{
    protected $model = Gebruiker::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $persoon = Persoon::factory()->create();

        return [
            'persoon_id' => $persoon->id,
            'inlog_naam' => strtolower($persoon->voornaam),
            'gebruikersnaam' => strtolower($persoon->voornaam) . '@voedselbank.nl',
            'wachtwoord' => Hash::make('password123'),
            'is_ingelogd' => $this->faker->boolean(30),
            'ingelogd' => $this->faker->optional(0.5)->dateTimeThisWeek(),
            'uitgelogd' => $this->faker->optional(0.3)->dateTimeThisWeek()
        ];
    }
}
