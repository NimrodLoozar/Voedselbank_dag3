<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $statussen = ['OpVoorraad', 'NietOpVoorraad', 'NietLeverbaar', 'OverHoudbaarheidsDatum'];
        $allergies = ['Gluten', 'Lactose', 'Pindas', 'Schaaldieren', 'Eier', 'Soja', null];

        return [
            'categorie_id' => Categorie::factory(),
            'naam' => $this->faker->randomElement([
                'Aardappel',
                'Ui',
                'Appel',
                'Banaan',
                'Kaas',
                'Rosbief',
                'Melk',
                'Margarine',
                'Ei',
                'Brood',
                'Gevulde Koek',
                'Fristi',
                'Appelsap',
                'Koffie',
                'Thee',
                'Pasta',
                'Rijst',
                'Tomatensoep',
                'Tomatensaus',
                'Peterselie',
                'Olie',
                'Mars',
                'Biscuit',
                'Paprika Chips',
                'Chocolade reep'
            ]),
            'soort_allergie' => $this->faker->randomElement($allergies),
            'barcode' => $this->faker->ean13,
            'houdbaarheidsdatum' => $this->faker->dateTimeBetween('now', '+2 years'),
            'omschrijving' => $this->faker->sentence(6),
            'status' => $this->faker->randomElement($statussen)
        ];
    }
}
