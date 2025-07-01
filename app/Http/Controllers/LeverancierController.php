<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeverancierController extends Controller
{
    public function index(Request $request)
    {
        // Gebruik stored procedure voor het ophalen van leveranciers
        $leverancierType = $request->get('leverancier_type');
        $leverancierId = $request->get('leverancier_id');
        
        $rawData = DB::select('CALL GetLeveranciersWithContacts(?, ?)', [$leverancierType, $leverancierId]);
        
        // Groepeer de data per leverancier
        $leveranciers = collect($rawData)->groupBy('leverancier_id')->map(function ($rows) {
            $firstRow = $rows->first();
            
            return (object) [
                'id' => $firstRow->leverancier_id,
                'naam' => $firstRow->leverancier_naam,
                'contact_persoon' => $firstRow->contact_persoon,
                'leverancier_nummer' => $firstRow->leverancier_nummer,
                'leverancier_type' => $firstRow->leverancier_type,
                'created_at' => $firstRow->leverancier_created_at,
                'updated_at' => $firstRow->leverancier_updated_at,
                'contacts' => $rows->filter(function ($row) {
                    return $row->contact_id !== null;
                })->unique('contact_id')->map(function ($row) {
                    return (object) [
                        'id' => $row->contact_id,
                        'straat' => $row->straat,
                        'huisnummer' => $row->huisnummer,
                        'toevoeging' => $row->toevoeging,
                        'postcode' => $row->postcode,
                        'woonplaats' => $row->woonplaats,
                        'email' => $row->email,
                        'mobiel' => $row->mobiel,
                        'volledig_adres' => $row->volledig_adres
                    ];
                })->values()
            ];
        })->values();
        
        return view('leveranciers.index', compact('leveranciers'));
    }

    public function create()
    {
        $contacts = Contact::all();
        return view('leveranciers.create', compact('contacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'contact_persoon' => 'required|string|max:255',
            'leverancier_nummer' => 'required|string|max:10|unique:leveranciers',
            'leverancier_type' => 'required|in:Bedrijf,Instelling,Overheid,Particulier,Donor'
        ]);

        $leverancier = Leverancier::create($request->all());

        if ($request->has('contact_ids')) {
            $leverancier->contacts()->attach($request->contact_ids);
        }

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol aangemaakt.');
    }

    public function show($id)
    {
        // Gebruik stored procedure voor specifieke leverancier
        $rawData = DB::select('CALL GetLeveranciersWithContacts(?, ?)', [null, $id]);
        
        if (empty($rawData)) {
            abort(404, 'Leverancier niet gevonden');
        }
        
        // Haal producten op via normale Eloquent relatie
        $leverancierModel = Leverancier::with('producten')->find($id);
        
        // Verwerk data voor één leverancier
        $firstRow = $rawData[0];
        $leverancierData = (object) [
            'id' => $firstRow->leverancier_id,
            'naam' => $firstRow->leverancier_naam,
            'contact_persoon' => $firstRow->contact_persoon,
            'leverancier_nummer' => $firstRow->leverancier_nummer,
            'leverancier_type' => $firstRow->leverancier_type,
            'created_at' => $firstRow->leverancier_created_at,
            'updated_at' => $firstRow->leverancier_updated_at,
            'contacts' => collect($rawData)->filter(function ($row) {
                return $row->contact_id !== null;
            })->unique('contact_id')->map(function ($row) {
                return (object) [
                    'id' => $row->contact_id,
                    'straat' => $row->straat,
                    'huisnummer' => $row->huisnummer,
                    'toevoeging' => $row->toevoeging,
                    'postcode' => $row->postcode,
                    'woonplaats' => $row->woonplaats,
                    'email' => $row->email,
                    'mobiel' => $row->mobiel,
                    'telefoon' => $row->mobiel, // Voor compatibility
                    'volledig_adres' => $row->volledig_adres
                ];
            })->values(),
            'producten' => $leverancierModel ? $leverancierModel->producten : collect()
        ];
        
        return view('leveranciers.show', ['leverancier' => $leverancierData]);
    }

    public function edit(Leverancier $leverancier)
    {
        $contacts = Contact::all();
        return view('leveranciers.edit', compact('leverancier', 'contacts'));
    }

    public function update(Request $request, Leverancier $leverancier)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'contact_persoon' => 'required|string|max:255',
            'leverancier_nummer' => 'required|string|max:10|unique:leveranciers,leverancier_nummer,' . $leverancier->id,
            'leverancier_type' => 'required|in:Bedrijf,Instelling,Overheid,Particulier,Donor'
        ]);

        $leverancier->update($request->all());

        $leverancier->contacts()->sync($request->contact_ids ?? []);

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol bijgewerkt.');
    }

    public function destroy(Leverancier $leverancier)
    {
        $leverancier->delete();

        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol verwijderd.');
    }
}
