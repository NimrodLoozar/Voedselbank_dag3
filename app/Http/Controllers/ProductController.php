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
}
