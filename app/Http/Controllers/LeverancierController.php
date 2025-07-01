<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Contact;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller voor het beheren van leveranciers
 * Handelt CRUD operaties af en gebruikt stored procedures voor geoptimaliseerde queries
 */
class LeverancierController extends Controller
{
    /**
     * Toon een overzicht van alle leveranciers met optionele filters
     * 
     * @param Request $request - HTTP request met optionele filter parameters
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Haal filter parameters uit de request
        // Haal filter parameters uit de request
        $leverancierType = $request->get('leverancier_type');
        $leverancierId = $request->get('leverancier_id');
        
        // Gebruik stored procedure voor het ophalen van leveranciers met hun contactgegevens
        $rawData = DB::select('CALL GetLeveranciersWithContacts(?, ?)', [$leverancierType, $leverancierId]);
        
        // Groepeer de ruwe data per leverancier om duplicatie te voorkomen
        $leveranciers = collect($rawData)->groupBy('leverancier_id')->map(function ($rows) {
            $firstRow = $rows->first();
            
            // Maak een leverancier object met alle benodigde eigenschappen
            return (object) [
                'id' => $firstRow->leverancier_id,
                'naam' => $firstRow->leverancier_naam,
                'contact_persoon' => $firstRow->contact_persoon,
                'leverancier_nummer' => $firstRow->leverancier_nummer,
                'leverancier_type' => $firstRow->leverancier_type,
                'created_at' => $firstRow->leverancier_created_at,
                'updated_at' => $firstRow->leverancier_updated_at,
                // Verwerk gekoppelde contacten en filter duplicaten
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
        
        // Retourneer de index view met de leveranciers data
        return view('leveranciers.index', compact('leveranciers'));
    }

    /**
     * Toon het formulier voor het aanmaken van een nieuwe leverancier
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Haal alle beschikbare contacten op voor in het formulier
        $contacts = Contact::all();
        return view('leveranciers.create', compact('contacts'));
    }

    /**
     * Sla een nieuwe leverancier op in de database
     * 
     * @param Request $request - HTTP request met leverancier gegevens
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valideer de inkomende data volgens de business rules
        $request->validate([
            'naam' => 'required|string|max:255',
            'contact_persoon' => 'required|string|max:255',
            'leverancier_nummer' => 'required|string|max:10|unique:leveranciers',
            'leverancier_type' => 'required|in:Bedrijf,Instelling,Overheid,Particulier,Donor'
        ]);

        // Maak een nieuwe leverancier aan met de gevalideerde data
        $leverancier = Leverancier::create($request->all());

        // Koppel geselecteerde contacten aan de leverancier (many-to-many relatie)
        if ($request->has('contact_ids')) {
            $leverancier->contacts()->attach($request->contact_ids);
        }

        // Redirect naar het overzicht met een succesbericht
        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol aangemaakt.');
    }

    /**
     * Toon de details van een specifieke leverancier
     * 
     * @param int $id - ID van de leverancier
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Gebruik stored procedure voor het ophalen van specifieke leverancier
        $rawData = DB::select('CALL GetLeveranciersWithContacts(?, ?)', [null, $id]);
        
        // Controleer of de leverancier bestaat
        if (empty($rawData)) {
            abort(404, 'Leverancier niet gevonden');
        }
        
        // Haal producten op via normale Eloquent relatie (niet via stored procedure)
        $leverancierModel = Leverancier::with('producten')->find($id);
        
        // Verwerk de ruwe data voor één specifieke leverancier
        $firstRow = $rawData[0];
        $leverancierData = (object) [
            'id' => $firstRow->leverancier_id,
            'naam' => $firstRow->leverancier_naam,
            'contact_persoon' => $firstRow->contact_persoon,
            'leverancier_nummer' => $firstRow->leverancier_nummer,
            'leverancier_type' => $firstRow->leverancier_type,
            'created_at' => $firstRow->leverancier_created_at,
            'updated_at' => $firstRow->leverancier_updated_at,
            // Verwerk alle gekoppelde contacten en filter duplicaten
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
                    'telefoon' => $row->mobiel, // Voor backward compatibility
                    'volledig_adres' => $row->volledig_adres
                ];
            })->values(),
            // Voeg producten toe via de Eloquent relatie
            'producten' => $leverancierModel ? $leverancierModel->producten : collect()
        ];
        
        // Retourneer de detail view met de leverancier data
        return view('leveranciers.show', ['leverancier' => $leverancierData]);
    }

    /**
     * Toon het formulier voor het bewerken van een bestaande leverancier
     * 
     * @param Leverancier $leverancier - De leverancier die bewerkt wordt
     * @return \Illuminate\View\View
     */
    public function edit(Leverancier $leverancier)
    {
        // Haal alle beschikbare contacten op voor in het formulier
        $contacts = Contact::all();
        return view('leveranciers.edit', compact('leverancier', 'contacts'));
    }

    /**
     * Werk een bestaande leverancier bij in de database
     * 
     * @param Request $request - HTTP request met bijgewerkte leverancier gegevens
     * @param Leverancier $leverancier - De leverancier die bijgewerkt wordt
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Leverancier $leverancier)
    {
        // Valideer de bijgewerkte data, exclusief het huidige leverancier nummer
        $request->validate([
            'naam' => 'required|string|max:255',
            'contact_persoon' => 'required|string|max:255',
            'leverancier_nummer' => 'required|string|max:10|unique:leveranciers,leverancier_nummer,' . $leverancier->id,
            'leverancier_type' => 'required|in:Bedrijf,Instelling,Overheid,Particulier,Donor'
        ]);

        // Werk de leverancier bij met de gevalideerde data
        $leverancier->update($request->all());

        // Synchroniseer de gekoppelde contacten (verwijder oude, voeg nieuwe toe)
        $leverancier->contacts()->sync($request->contact_ids ?? []);

        // Redirect naar het overzicht met een succesbericht
        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol bijgewerkt.');
    }

    /**
     * Verwijder een leverancier uit de database
     * 
     * @param Leverancier $leverancier - De leverancier die verwijderd wordt
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Leverancier $leverancier)
    {
        // Verwijder de leverancier (cascade regels zorgen voor gekoppelde data)
        $leverancier->delete();

        // Redirect naar het overzicht met een succesbericht
        return redirect()->route('leveranciers.index')
            ->with('success', 'Leverancier succesvol verwijderd.');
    }

    /**
     * Toon het formulier voor het bewerken van de houdbaarheidsdatum van een product
     * 
     * @param Leverancier $leverancier - De leverancier waartoe het product behoort
     * @param Product $product - Het product waarvan de houdbaarheidsdatum bewerkt wordt
     * @return \Illuminate\View\View
     */
    public function editProduct(Leverancier $leverancier, Product $product)
    {
        // Haal houdbaarheidsdatum uit het product zelf, niet uit de pivot
        return view('leveranciers.edit', compact('leverancier', 'product'));
    }

    /**
     * Werk de houdbaarheidsdatum van een product bij in de database
     * 
     * @param Request $request - HTTP request met bijgewerkte product gegevens
     * @param Leverancier $leverancier - De leverancier waartoe het product behoort
     * @param Product $product - Het product waarvan de houdbaarheidsdatum bijgewerkt wordt
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProduct(Request $request, Leverancier $leverancier, Product $product)
    {
        $request->validate([
            'houdbaarheidsdatum' => 'required|date',
        ]);

        $oudeDatum = $product->houdbaarheidsdatum ? \Carbon\Carbon::parse($product->houdbaarheidsdatum) : null;
        $nieuweDatum = \Carbon\Carbon::parse($request->houdbaarheidsdatum);

        // Als er al een datum is, check of verlenging maximaal 7 dagen is
        if ($oudeDatum && $nieuweDatum->gt($oudeDatum)) {
            $verschil = $oudeDatum->diffInDays($nieuweDatum);
            if ($verschil > 7) {
                return redirect()->back()
                    ->with('error', 'De houdbaarheidsdatum is niet gewijzigd. De houdbaarheidsdatum mag met maximaal 7 dagen worden verlengd')
                    ->withInput();
            }
        }

        $product->houdbaarheidsdatum = $nieuweDatum->format('Y-m-d');
        $product->save();

        // Wireframe-05: altijd deze melding bij succes
        return redirect()->route('leveranciers.show', $leverancier->id)
            ->with('success', 'De houdbaarbaarheidsdatum is gewijzigd');
    }
}
