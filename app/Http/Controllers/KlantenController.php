<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Gezin;
use App\Models\Klanten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlantenController extends Controller
{
    /**
     * Display a listing of all customers (gezinnen) with their contact information
     */
    public function index(Request $request)
    {
        $postcode = $request->get('postcode');
        $klanten = collect();
        $message = null;
        
        // Get all unique postcodes for the dropdown
        $postcodes = Contact::whereHas('gezinnen')
            ->distinct()
            ->orderBy('postcode')
            ->pluck('postcode')
            ->filter();

        if ($postcode) {
            // Filter customers by postcode
            $klanten = Klanten::getKlantenByPostcode($postcode);
            
            if ($klanten->isEmpty()) {
                $message = "Er zijn geen klanten bekend die de geselecteerde postcode hebben";
            }
        } else {
            // Show all customers when no postcode filter is applied
            $klanten = Klanten::getAllKlanten();
        }

        return view('klanten.index', compact('klanten', 'postcodes', 'postcode', 'message'));
    }

    /**
     * Display the specified customer with detailed information
     */
    public function show($id)
    {
        $gezin = Gezin::with(['personen', 'contacts', 'eetwensen', 'voedselpakketten'])
            ->findOrFail($id);
        
        $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
        $contact = $gezin->contacts->first();
        
        return view('klanten.show', compact('gezin', 'vertegenwoordiger', 'contact'));
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit($id)
    {
        $gezin = Gezin::with(['personen', 'contacts'])->findOrFail($id);
        $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
        $contact = $gezin->contacts->first();
        
        return view('klanten.edit', compact('gezin', 'vertegenwoordiger', 'contact'));
    }

    /**
     * Update the specified customer in storage
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'vertegenwoordiger_voornaam' => 'required|string|max:255',
            'vertegenwoordiger_achternaam' => 'required|string|max:255',
            'vertegenwoordiger_tussenvoegsel' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'mobiel' => ['nullable', 'string', 'max:20', function ($attribute, $value, $fail) {
                if ($value && !Klanten::isValidDutchMobile($value)) {
                    $fail('Het mobiele nummer moet een geldig Nederlands mobiel nummer zijn (bijv. 06xxxxxxxx of +316xxxxxxxx)');
                }
            }],
            'straat' => 'nullable|string|max:255',
            'huisnummer' => 'nullable|string|max:10',
            'toevoeging' => 'nullable|string|max:10',
            'postcode' => ['nullable', 'string', 'max:10', function ($attribute, $value, $fail) {
                if ($value && !Klanten::isValidMaaskantjePostcode($value)) {
                    $fail('De postcode komt niet uit de regio Maaskantje');
                }
            }],
            'woonplaats' => 'nullable|string|max:255',
        ]);

        // Check if postcode is being changed to a non-Maaskantje region
        $gezin = Gezin::findOrFail($id);
        $contact = $gezin->contacts->first();
        
        if ($request->postcode && $contact) {
            if (!Klanten::canUpdateContactDetails($contact->postcode, $request->postcode)) {
                return redirect()->back()
                    ->withErrors([
                        'postcode' => 'De postcode komt niet uit de regio Maaskantje',
                        'general' => 'De contactgegevens van de geselecteerde klant kunnen niet gewijzigd worden'
                    ])
                    ->withInput();
            }
        }
        
        // Update vertegenwoordiger
        $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
        if ($vertegenwoordiger) {
            $vertegenwoordiger->update([
                'voornaam' => $request->vertegenwoordiger_voornaam,
                'tussenvoegsel' => $request->vertegenwoordiger_tussenvoegsel,
                'achternaam' => $request->vertegenwoordiger_achternaam,
            ]);
        }

        // Update contact information
        if ($contact) {
            $contact->update([
                'email' => $request->email,
                'mobiel' => $request->mobiel,
                'straat' => $request->straat,
                'huisnummer' => $request->huisnummer,
                'toevoeging' => $request->toevoeging,
                'postcode' => $request->postcode,
                'woonplaats' => $request->woonplaats,
            ]);
        }

        return redirect()->route('klanten.show', $gezin)
            ->with('success', 'De klantgegevens zijn gewijzigd');
    }
}