<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klanten extends Model
{
    /**
     * Check if the postcode is valid for the Maaskantje region
     */
    public static function isValidMaaskantjePostcode($postcode)
    {
        if (!$postcode) {
            return true; // Allow empty postcodes
        }
        
        // Maaskantje region postcodes start with 5271
        return preg_match('/^5271[A-Z]{2}$/', strtoupper(str_replace(' ', '', $postcode)));
    }

    /**
     * Get all customers with their contact information
     */
    public static function getAllKlanten()
    {
        return Gezin::with(['personen' => function($query) {
                $query->where('is_vertegenwoordiger', true);
            }, 'contacts'])
            ->get()
            ->map(function ($gezin) {
                return self::transformGezinToKlant($gezin);
            });
    }

    /**
     * Get customers filtered by postcode
     */
    public static function getKlantenByPostcode($postcode)
    {
        return Gezin::with(['personen' => function($query) {
                $query->where('is_vertegenwoordiger', true);
            }, 'contacts' => function($query) use ($postcode) {
                $query->where('postcode', $postcode);
            }])
            ->whereHas('contacts', function($query) use ($postcode) {
                $query->where('postcode', $postcode);
            })
            ->get()
            ->map(function ($gezin) {
                return self::transformGezinToKlant($gezin);
            });
    }

    /**
     * Transform a Gezin model to a customer object
     */
    private static function transformGezinToKlant($gezin)
    {
        $vertegenwoordiger = $gezin->personen->first();
        $contact = $gezin->contacts->first();
        
        return (object) [
            'gezin_id' => $gezin->id,
            'gezin_naam' => $gezin->naam,
            'gezin_code' => $gezin->code,
            'vertegenwoordiger_naam' => $vertegenwoordiger ? $vertegenwoordiger->volledige_naam : 'Onbekend',
            'aantal_volwassenen' => $gezin->aantal_volwassenen,
            'aantal_kinderen' => $gezin->aantal_kinderen,
            'aantal_babys' => $gezin->aantal_babys,
            'totaal_personen' => $gezin->totaal_aantal_personen,
            'straat' => $contact ? $contact->straat : '',
            'huisnummer' => $contact ? $contact->huisnummer : '',
            'toevoeging' => $contact ? $contact->toevoeging : '',
            'postcode' => $contact ? $contact->postcode : '',
            'woonplaats' => $contact ? $contact->woonplaats : '',
            'email' => $contact ? $contact->email : '',
            'mobiel' => $contact ? $contact->mobiel : '',
        ];
    }

    /**
     * Validate if contact details can be updated with new postcode
     */
    public static function canUpdateContactDetails($currentPostcode, $newPostcode)
    {
        if (!$newPostcode || $currentPostcode === $newPostcode) {
            return true;
        }

        return self::isValidMaaskantjePostcode($newPostcode);
    }
}