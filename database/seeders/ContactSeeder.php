<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            ['id' => 1, 'straat' => 'Prinses Irenestraat', 'huisnummer' => '12', 'toevoeging' => 'A', 'postcode' => '5271TH', 'woonplaats' => 'Maaskantje', 'email' => 'j.van.zevenhuizen@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 2, 'straat' => 'Gibraltarstraat', 'huisnummer' => '234', 'toevoeging' => null, 'postcode' => '5271TJ', 'woonplaats' => 'Maaskantje', 'email' => 'a.bergkamp@hotmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 3, 'straat' => 'Der Kinderenstraat', 'huisnummer' => '456', 'toevoeging' => 'Bis', 'postcode' => '5271TH', 'woonplaats' => 'Maaskantje', 'email' => 's.van.de.heuvel@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 4, 'straat' => 'Nachtegaalstraat', 'huisnummer' => '233', 'toevoeging' => 'A', 'postcode' => '5271TJ', 'woonplaats' => 'Maaskantje', 'email' => 'e.scherder@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 5, 'straat' => 'Bertram Russellstraat', 'huisnummer' => '45', 'toevoeging' => null, 'postcode' => '5271TH', 'woonplaats' => 'Maaskantje', 'email' => 'f.de.jong@hotmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 6, 'straat' => 'Leonardo Da VinciHof', 'huisnummer' => '34', 'toevoeging' => null, 'postcode' => '5271ZE', 'woonplaats' => 'Maaskantje', 'email' => 'h.van.der.berg@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 7, 'straat' => 'Siegfried Knutsenlaan', 'huisnummer' => '234', 'toevoeging' => null, 'postcode' => '5271ZE', 'woonplaats' => 'Maaskantje', 'email' => 'r.ter.weijden@ah.nl', 'mobiel' => '+31 623456123'],
            ['id' => 8, 'straat' => 'Theo de Bokstraat', 'huisnummer' => '256', 'toevoeging' => null, 'postcode' => '5271ZH', 'woonplaats' => 'Maaskantje', 'email' => 'l.pastoor@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 9, 'straat' => 'Meester van Leerhof', 'huisnummer' => '2', 'toevoeging' => 'A', 'postcode' => '5271ZH', 'woonplaats' => 'Maaskantje', 'email' => 'm.yazidi@gemeenteutrecht.nl', 'mobiel' => '+31 623456123'],
            ['id' => 10, 'straat' => 'Van Wemelenplantsoen', 'huisnummer' => '300', 'toevoeging' => null, 'postcode' => '5271TH', 'woonplaats' => 'Maaskantje', 'email' => 'b.van.driel@gmail.com', 'mobiel' => '+31 623456123'],
            ['id' => 11, 'straat' => 'Terlingenhof', 'huisnummer' => '20', 'toevoeging' => null, 'postcode' => '5271TH', 'woonplaats' => 'Maaskantje', 'email' => 'j.pastorius@gmail.com', 'mobiel' => '+31 623456356'],
            ['id' => 12, 'straat' => 'Veldhoen', 'huisnummer' => '31', 'toevoeging' => null, 'postcode' => '5271ZE', 'woonplaats' => 'Maaskantje', 'email' => 's.dollaard@gmail.com', 'mobiel' => '+31 623452314'],
            ['id' => 13, 'straat' => 'ScheringaDreef', 'huisnummer' => '37', 'toevoeging' => null, 'postcode' => '5271ZE', 'woonplaats' => 'Vught', 'email' => 'j.blokker@gemeentevught.nl', 'mobiel' => '+31 623452314']
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
