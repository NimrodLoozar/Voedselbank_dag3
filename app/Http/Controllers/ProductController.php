<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use App\Models\Leverancier;
use App\Models\Magazijn;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $producten = Product::with(['categorie', 'leveranciers', 'magazijnen'])->get();
        return view('producten.index', compact('producten'));
    }

    public function create()
    {
        $categories = Categorie::all();
        $leveranciers = Leverancier::all();
        $magazijnen = Magazijn::all();
        return view('producten.create', compact('categories', 'leveranciers', 'magazijnen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'naam' => 'required|string|max:255',
            'soort_allergie' => 'nullable|string|max:255',
            'barcode' => 'required|string|max:255',
            'houdbaarheidsdatum' => 'required|date',
            'omschrijving' => 'required|string',
            'status' => 'required|in:OpVoorraad,NietOpVoorraad,NietLeverbaar,OverHoudbaarheidsDatum'
        ]);

        $product = Product::create($request->all());

        // Attach leveranciers with pivot data
        if ($request->has('leverancier_data')) {
            foreach ($request->leverancier_data as $leverancierData) {
                if (isset($leverancierData['leverancier_id'])) {
                    $product->leveranciers()->attach($leverancierData['leverancier_id'], [
                        'datum_aangeleverd' => $leverancierData['datum_aangeleverd'] ?? now(),
                        'datum_eerst_volgende_levering' => $leverancierData['datum_eerst_volgende_levering'] ?? now()->addDays(30)
                    ]);
                }
            }
        }

        // Attach magazijnen with pivot data
        if ($request->has('magazijn_data')) {
            foreach ($request->magazijn_data as $magazijnData) {
                if (isset($magazijnData['magazijn_id'])) {
                    $product->magazijnen()->attach($magazijnData['magazijn_id'], [
                        'locatie' => $magazijnData['locatie'] ?? 'Onbekend'
                    ]);
                }
            }
        }

        return redirect()->route('producten.index')
            ->with('success', 'Product succesvol aangemaakt.');
    }

    public function show(Product $product)
    {
        $product->load(['categorie', 'leveranciers', 'magazijnen', 'voedselpakketten']);
        return view('producten.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Categorie::all();
        $leveranciers = Leverancier::all();
        $magazijnen = Magazijn::all();
        return view('producten.edit', compact('product', 'categories', 'leveranciers', 'magazijnen'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'categorie_id' => 'required|exists:categories,id',
            'naam' => 'required|string|max:255',
            'soort_allergie' => 'nullable|string|max:255',
            'barcode' => 'required|string|max:255',
            'houdbaarheidsdatum' => 'required|date',
            'omschrijving' => 'required|string',
            'status' => 'required|in:OpVoorraad,NietOpVoorraad,NietLeverbaar,OverHoudbaarheidsDatum'
        ]);

        $product->update($request->all());

        // Sync leveranciers with pivot data
        $leverancierSync = [];
        if ($request->has('leverancier_data')) {
            foreach ($request->leverancier_data as $leverancierData) {
                if (isset($leverancierData['leverancier_id'])) {
                    $leverancierSync[$leverancierData['leverancier_id']] = [
                        'datum_aangeleverd' => $leverancierData['datum_aangeleverd'] ?? now(),
                        'datum_eerst_volgende_levering' => $leverancierData['datum_eerst_volgende_levering'] ?? now()->addDays(30)
                    ];
                }
            }
        }
        $product->leveranciers()->sync($leverancierSync);

        // Sync magazijnen with pivot data
        $magazijnSync = [];
        if ($request->has('magazijn_data')) {
            foreach ($request->magazijn_data as $magazijnData) {
                if (isset($magazijnData['magazijn_id'])) {
                    $magazijnSync[$magazijnData['magazijn_id']] = [
                        'locatie' => $magazijnData['locatie'] ?? 'Onbekend'
                    ];
                }
            }
        }
        $product->magazijnen()->sync($magazijnSync);

        return redirect()->route('producten.index')
            ->with('success', 'Product succesvol bijgewerkt.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('producten.index')
            ->with('success', 'Product succesvol verwijderd.');
    }

    /**
     * Display inventory overview of all products in stock
     */
    public function inventoryOverview(Request $request)
    {
        $categories = Categorie::all();

        $query = Product::with(['categorie', 'magazijnen'])
            ->whereHas('magazijnen'); // Only products that are in warehouses

        // Filter by category if selected
        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        $producten = $query->paginate(10); // 10 items per page
        $selectedCategory = $request->categorie_id;

        // Check if category filter returned no results
        if ($request->filled('categorie_id') && $producten->isEmpty()) {
            $categorie = Categorie::find($request->categorie_id);
            return view('inventory.overview', compact('producten', 'categories', 'selectedCategory'))
                ->with('error', 'Er zijn geen producten bekend die behoren bij de geselecteerde productcategorie');
        }

        // Add success message if category was selected and has results
        $message = null;
        if ($request->filled('categorie_id') && $producten->isNotEmpty()) {
            $categorie = Categorie::find($request->categorie_id);
            $message = "Voorraad voor categorie '{$categorie->naam}' weergegeven";
        }

        return view('inventory.overview', compact('producten', 'categories', 'selectedCategory'))
            ->with('success', $message);
    }

    /**
     * Show detailed view of a product including inventory details
     */
    public function showInventoryDetails(Product $product)
    {
        $product->load(['categorie', 'leveranciers', 'magazijnen']);

        return view('inventory.details', compact('product'));
    }

    /**
     * Show form to edit product inventory
     */
    public function editInventory(Product $product)
    {
        $product->load(['categorie', 'leveranciers', 'magazijnen']);

        return view('inventory.edit', compact('product'));
    }

    /**
     * Update product inventory
     */
    public function updateInventory(Request $request, Product $product)
    {
        $request->validate([
            'magazijn_updates' => 'required|array',
            'magazijn_updates.*.magazijn_id' => 'required|exists:magazijnen,id',
            'magazijn_updates.*.aantal_uitgeleverd' => 'required|integer|min:0',
            'magazijn_updates.*.locatie' => 'required|string|max:255',
            'uitleveringsdatum' => 'nullable|date',
        ]);

        // Validation: Check if user tries to deliver more than available in stock
        foreach ($request->magazijn_updates as $update) {
            $magazijn = Magazijn::findOrFail($update['magazijn_id']);
            $currentStock = $magazijn->aantal; // Current remaining stock
            $aantalUitgeleverd = $update['aantal_uitgeleverd']; // Amount to deliver

            // Check if delivery amount exceeds available stock
            if ($aantalUitgeleverd > $currentStock) {
                return back()
                    ->withErrors(['error' => 'Er worden meer producten uitgeleverd dan er in voorraad zijn'])
                    ->withInput();
            }
        }

        // Update warehouse inventory
        foreach ($request->magazijn_updates as $update) {
            $magazijn = Magazijn::findOrFail($update['magazijn_id']);
            $aantalUitgeleverd = $update['aantal_uitgeleverd'];

            // Update the remaining stock (subtract delivered amount)
            $newStock = $magazijn->aantal - $aantalUitgeleverd;

            $updateData = ['aantal' => $newStock];

            // Set delivery date if provided or if products are being delivered
            if ($request->filled('uitleveringsdatum')) {
                $updateData['uitleveringsdatum'] = $request->uitleveringsdatum;
            } elseif ($aantalUitgeleverd > 0) {
                $updateData['uitleveringsdatum'] = now();
            }

            $magazijn->update($updateData);

            // Update pivot table with location info
            $product->magazijnen()->updateExistingPivot($update['magazijn_id'], [
                'locatie' => $update['locatie']
            ]);
        }

        return redirect()
            ->route('inventory.details', $product)
            ->with('success', 'De productgegevens zijn gewijzigd');
    }
}
