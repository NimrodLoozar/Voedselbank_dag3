<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categorie>
 */
class CategorieFactory extends Factory
{
    protected $model = Categorie::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $categories = [
            ['naam' => 'AGF', 'omschrijving' => 'Aardappelen groente en fruit'],
            ['naam' => 'KV', 'omschrijving' => 'Kaas en vleeswaren'],
            ['naam' => 'ZPE', 'omschrijving' => 'Zuivel plantaardig en eieren'],
            ['naam' => 'BB', 'omschrijving' => 'Bakkerij en Banket'],
            ['naam' => 'FSKT', 'omschrijving' => 'Frisdranken, sappen, koffie en thee'],
            ['naam' => 'PRW', 'omschrijving' => 'Pasta, rijst en wereldkeuken'],
            ['naam' => 'SSKO', 'omschrijving' => 'Soepen, sauzen, kruiden en olie'],
            ['naam' => 'SKCC', 'omschrijving' => 'Snoep, koek, chips en chocolade'],
            ['naam' => 'BVH', 'omschrijving' => 'Baby, verzorging en hygiëne']
        ];

        $categorie = $this->faker->randomElement($categories);

        return [
            'naam' => $categorie['naam'],
            'omschrijving' => $categorie['omschrijving']
        ];
    }
}
