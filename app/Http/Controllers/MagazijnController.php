<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

/**
 * Controller voor magazijn items van de voedselbank.
 * 
 * Hier kunnen we magazijn items bekijken, toevoegen, aanpassen en verwijderen.
 * We checken ook of de datums kloppen en of alle verplichte velden zijn ingevuld.
 */
class MagazijnController extends Controller
{
    /**
     * Laat alle magazijn items zien op de hoofdpagina.
     * We halen ook de bijbehorende producten op.
     */
    public function index()
    {
        try {
            $magazijnen = Magazijn::with('producten')->get();
            return view('magazijnen.index', compact('magazijnen'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen magazijn overzicht: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Er is een fout opgetreden bij het laden van het magazijn overzicht. Probeer het opnieuw.');
        }
    }

    /**
     * Toont het formulier om een nieuw magazijn item toe te voegen.
     */
    public function create()
    {
        return view('magazijnen.create');
    }

    /**
     * Slaat een nieuw magazijn item op.
     * 
     * Eerst controleren we of alle gegevens correct zijn ingevuld.
     * De uitleveringsdatum moet later zijn dan de ontvangstdatum.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'ontvangstdatum' => 'required|date',
                'uitleveringsdatum' => 'nullable|date|after:ontvangstdatum',
                'verpakkings_eenheid' => 'required|string|max:255',
                'aantal' => 'required|integer|min:1'
            ]);

            Magazijn::create($request->all());

            return redirect()->route('magazijnen.index')
                ->with('success', 'Magazijn succesvol aangemaakt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validatie fout bij magazijn aanmaken: ' . json_encode($e->errors()));
            throw $e; // Laat Laravel de validatie errors afhandelen
        } catch (\Exception $e) {
            Log::error('Fout bij aanmaken magazijn: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het aanmaken van het magazijn item. Probeer het opnieuw.');
        }
    }

    /**
     * Laat de details van één specifiek magazijn item zien.
     * Inclusief alle gekoppelde producten.
     */
    public function show(Magazijn $magazijn)
    {
        try {
            $magazijn->load('producten');
            return view('magazijnen.show', compact('magazijn'));
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen magazijn details: ' . $e->getMessage());

            return redirect()->route('magazijnen.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van de magazijn details.');
        }
    }

    /**
     * Toont het formulier om een bestaand magazijn item te bewerken.
     */
    public function edit(Magazijn $magazijn)
    {
        return view('magazijnen.edit', compact('magazijn'));
    }

    /**
     * Slaat de wijzigingen van een magazijn item op.
     * 
     * We doen dezelfde validatie als bij het aanmaken van een nieuw item.
     */
    public function update(Request $request, Magazijn $magazijn)
    {
        try {
            $request->validate([
                'ontvangstdatum' => 'required|date',
                'uitleveringsdatum' => 'nullable|date|after:ontvangstdatum',
                'verpakkings_eenheid' => 'required|string|max:255',
                'aantal' => 'required|integer|min:1'
            ]);

            $magazijn->update($request->all());

            return redirect()->route('magazijnen.index')
                ->with('success', 'Magazijn succesvol bijgewerkt.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validatie fout bij magazijn update: ' . json_encode($e->errors()));
            throw $e;
        } catch (\Exception $e) {
            Log::error('Fout bij bijwerken magazijn: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Er is een fout opgetreden bij het bijwerken van het magazijn item.');
        }
    }

    /**
     * Verwijdert een magazijn item definitief uit de database.
     */
    public function destroy(Magazijn $magazijn)
    {
        try {
            $magazijn->delete();

            return redirect()->route('magazijnen.index')
                ->with('success', 'Magazijn succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Fout bij verwijderen magazijn: ' . $e->getMessage());

            return redirect()->route('magazijnen.index')
                ->with('error', 'Er is een fout opgetreden bij het verwijderen van het magazijn item.');
        }
    }

    /**
     * Haal magazijn statistieken op
     */
    public function getStatistics()
    {
        try {
            $statistics = [
                'totaal_magazijnen' => Magazijn::count(),
                'totaal_items' => Magazijn::sum('aantal'),
                'nog_in_voorraad' => Magazijn::whereNull('uitleveringsdatum')->count(),
                'uitgeleverd' => Magazijn::whereNotNull('uitleveringsdatum')->count(),
            ];

            return response()->json([
                'success' => true,
                'data' => $statistics
            ]);
        } catch (\Exception $e) {
            Log::error('Fout bij ophalen magazijn statistieken: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Er is een fout opgetreden bij het ophalen van de statistieken.'
            ], 500);
        }
    }
}
