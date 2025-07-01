<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $producten = [
            ['id' => 1, 'categorie_id' => 1, 'naam' => 'Aardappel', 'soort_allergie' => null, 'barcode' => '8719587321239', 'houdbaarheidsdatum' => '2024-07-12', 'omschrijving' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['id' => 2, 'categorie_id' => 1, 'naam' => 'Aardappel', 'soort_allergie' => null, 'barcode' => '8719587321239', 'houdbaarheidsdatum' => '2024-07-26', 'omschrijving' => 'Kruimige aardappel', 'status' => 'OpVoorraad'],
            ['id' => 3, 'categorie_id' => 1, 'naam' => 'Ui', 'soort_allergie' => null, 'barcode' => '8719437321335', 'houdbaarheidsdatum' => '2024-09-02', 'omschrijving' => 'Gele ui', 'status' => 'NietOpVoorraad'],
            ['id' => 4, 'categorie_id' => 1, 'naam' => 'Appel', 'soort_allergie' => null, 'barcode' => '8719486321332', 'houdbaarheidsdatum' => '2024-08-16', 'omschrijving' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['id' => 5, 'categorie_id' => 1, 'naam' => 'Appel', 'soort_allergie' => null, 'barcode' => '8719486321332', 'houdbaarheidsdatum' => '2024-09-23', 'omschrijving' => 'Granny Smith', 'status' => 'NietLeverbaar'],
            ['id' => 6, 'categorie_id' => 1, 'naam' => 'Banaan', 'soort_allergie' => 'Banaan', 'barcode' => '8719484321336', 'houdbaarheidsdatum' => '2024-07-12', 'omschrijving' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 7, 'categorie_id' => 1, 'naam' => 'Banaan', 'soort_allergie' => 'Banaan', 'barcode' => '8719484321336', 'houdbaarheidsdatum' => '2024-07-19', 'omschrijving' => 'Biologische Banaan', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 8, 'categorie_id' => 2, 'naam' => 'Kaas', 'soort_allergie' => 'Lactose', 'barcode' => '8719487421338', 'houdbaarheidsdatum' => '2024-09-19', 'omschrijving' => 'Jonge Kaas', 'status' => 'OpVoorraad'],
            ['id' => 9, 'categorie_id' => 2, 'naam' => 'Rosbief', 'soort_allergie' => null, 'barcode' => '8719487421331', 'houdbaarheidsdatum' => '2024-07-23', 'omschrijving' => 'Rundvlees', 'status' => 'OpVoorraad'],
            ['id' => 10, 'categorie_id' => 3, 'naam' => 'Melk', 'soort_allergie' => 'Lactose', 'barcode' => '8719447321332', 'houdbaarheidsdatum' => '2024-07-23', 'omschrijving' => 'Halfvolle melk', 'status' => 'OpVoorraad'],
            ['id' => 11, 'categorie_id' => 3, 'naam' => 'Margarine', 'soort_allergie' => null, 'barcode' => '8719486321336', 'houdbaarheidsdatum' => '2024-08-02', 'omschrijving' => 'Plantaardige boter', 'status' => 'OpVoorraad'],
            ['id' => 12, 'categorie_id' => 3, 'naam' => 'Ei', 'soort_allergie' => 'Eier', 'barcode' => '8719487421334', 'houdbaarheidsdatum' => '2024-08-04', 'omschrijving' => 'Scharrelei', 'status' => 'OpVoorraad'],
            ['id' => 13, 'categorie_id' => 4, 'naam' => 'Brood', 'soort_allergie' => 'Gluten', 'barcode' => '8719487721337', 'houdbaarheidsdatum' => '2024-07-07', 'omschrijving' => 'Volkoren brood', 'status' => 'OpVoorraad'],
            ['id' => 14, 'categorie_id' => 4, 'naam' => 'Gevulde Koek', 'soort_allergie' => 'Amandel', 'barcode' => '8719483321333', 'houdbaarheidsdatum' => '2024-09-04', 'omschrijving' => 'Banketbakkers kwaliteit', 'status' => 'OpVoorraad'],
            ['id' => 15, 'categorie_id' => 5, 'naam' => 'Fristi', 'soort_allergie' => 'Lactose', 'barcode' => '8719487121331', 'houdbaarheidsdatum' => '2024-10-28', 'omschrijving' => 'Frisdrank', 'status' => 'NietOpVoorraad'],
            ['id' => 16, 'categorie_id' => 5, 'naam' => 'Appelsap', 'soort_allergie' => null, 'barcode' => '8719487521335', 'houdbaarheidsdatum' => '2024-10-19', 'omschrijving' => '100% vruchtensap', 'status' => 'OpVoorraad'],
            ['id' => 17, 'categorie_id' => 5, 'naam' => 'Koffie', 'soort_allergie' => 'Caffeïne', 'barcode' => '8719487381338', 'houdbaarheidsdatum' => '2024-10-23', 'omschrijving' => 'Arabica koffie', 'status' => 'OverHoudbaarheidsDatum'],
            ['id' => 18, 'categorie_id' => 5, 'naam' => 'Thee', 'soort_allergie' => 'Theïne', 'barcode' => '8719487329339', 'houdbaarheidsdatum' => '2024-09-02', 'omschrijving' => 'Ceylon thee', 'status' => 'OpVoorraad'],
            ['id' => 19, 'categorie_id' => 6, 'naam' => 'Pasta', 'soort_allergie' => 'Gluten', 'barcode' => '8719487321334', 'houdbaarheidsdatum' => '2024-12-16', 'omschrijving' => 'Macaroni', 'status' => 'NietLeverbaar'],
            ['id' => 20, 'categorie_id' => 6, 'naam' => 'Rijst', 'soort_allergie' => null, 'barcode' => '8719487331332', 'houdbaarheidsdatum' => '2024-12-25', 'omschrijving' => 'Basmati Rijst', 'status' => 'OpVoorraad'],
            ['id' => 21, 'categorie_id' => 6, 'naam' => 'Knorr Nasi Mix', 'soort_allergie' => null, 'barcode' => '871948735135', 'houdbaarheidsdatum' => '2024-12-13', 'omschrijving' => 'Nasi kruiden', 'status' => 'OpVoorraad'],
            ['id' => 22, 'categorie_id' => 7, 'naam' => 'Tomatensoep', 'soort_allergie' => null, 'barcode' => '8719487371337', 'houdbaarheidsdatum' => '2024-12-23', 'omschrijving' => 'Romige tomatensoep', 'status' => 'OpVoorraad'],
            ['id' => 23, 'categorie_id' => 7, 'naam' => 'Tomatensaus', 'soort_allergie' => null, 'barcode' => '8719487341334', 'houdbaarheidsdatum' => '2024-12-21', 'omschrijving' => 'Pizza saus', 'status' => 'NietOpVoorraad'],
            ['id' => 24, 'categorie_id' => 7, 'naam' => 'Peterselie', 'soort_allergie' => null, 'barcode' => '8719487321636', 'houdbaarheidsdatum' => '2024-07-31', 'omschrijving' => 'Verse kruidenpot', 'status' => 'OpVoorraad'],
            ['id' => 25, 'categorie_id' => 8, 'naam' => 'Olie', 'soort_allergie' => null, 'barcode' => '8719487327337', 'houdbaarheidsdatum' => '2024-12-27', 'omschrijving' => 'Olijfolie', 'status' => 'OpVoorraad'],
            ['id' => 26, 'categorie_id' => 8, 'naam' => 'Mars', 'soort_allergie' => null, 'barcode' => '8719487324334', 'houdbaarheidsdatum' => '2024-12-11', 'omschrijving' => 'Snoep', 'status' => 'OpVoorraad'],
            ['id' => 27, 'categorie_id' => 8, 'naam' => 'Biscuit', 'soort_allergie' => null, 'barcode' => '8719487311331', 'houdbaarheidsdatum' => '2024-08-07', 'omschrijving' => 'San Francisco biscuit', 'status' => 'OpVoorraad'],
            ['id' => 28, 'categorie_id' => 8, 'naam' => 'Paprika Chips', 'soort_allergie' => null, 'barcode' => '87194873218398', 'houdbaarheidsdatum' => '2024-12-22', 'omschrijving' => 'Ribbelchips paprika', 'status' => 'OpVoorraad'],
            ['id' => 29, 'categorie_id' => 8, 'naam' => 'Chocolade reep', 'soort_allergie' => 'Cacoa', 'barcode' => '8719487321533', 'houdbaarheidsdatum' => '2024-11-21', 'omschrijving' => 'Tony Chocolonely', 'status' => 'OpVoorraad']
        ];

        foreach ($producten as $product) {
            Product::create($product);
        }
    }
}
