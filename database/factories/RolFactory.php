<?php

namespace Database\Factories;

use App\Models\Rol;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Rol>
 */
class RolFactory extends Factory
{
    protected $model = Rol::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $rollen = ['Manager', 'Medewerker', 'Vrijwilliger'];

        return [
            'naam' => $this->faker->randomElement($rollen)
        ];
    }
}
