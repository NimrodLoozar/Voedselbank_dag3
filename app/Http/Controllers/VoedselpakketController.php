<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Gezin;
use App\Models\Product;
use Illuminate\Http\Request;

class VoedselpakketController extends Controller
{
    public function index()
    {
        $voedselpakketten = Voedselpakket::with(['gezin', 'producten'])->get();
        return view('voedselpakketten.index', compact('voedselpakketten'));
    }

    public function create()
    {
        $gezinnen = Gezin::all();
        $producten = Product::where('status', 'OpVoorraad')->get();
        return view('voedselpakketten.create', compact('gezinnen', 'producten'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gezin_id' => 'required|exists:gezinnen,id',
            'pakket_nummer' => 'required|integer',
            'datum_samenstelling' => 'required|date',
            'datum_uitgifte' => 'nullable|date|after_or_equal:datum_samenstelling',
            'status' => 'required|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
        ]);

        $voedselpakket = Voedselpakket::create($request->all());

        // Attach producten with aantal
        if ($request->has('product_data')) {
            foreach ($request->product_data as $productData) {
                if (isset($productData['product_id']) && isset($productData['aantal_product_eenheden'])) {
                    $voedselpakket->producten()->attach($productData['product_id'], [
                        'aantal_product_eenheden' => $productData['aantal_product_eenheden']
                    ]);
                }
            }
        }

        return redirect()->route('voedselpakketten.index')
            ->with('success', 'Voedselpakket succesvol aangemaakt.');
    }

    public function show(Voedselpakket $voedselpakket)
    {
        $voedselpakket->load(['gezin', 'producten']);
        return view('voedselpakketten.show', compact('voedselpakket'));
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        $gezinnen = Gezin::all();
        $producten = Product::where('status', 'OpVoorraad')->get();
        return view('voedselpakketten.edit', compact('voedselpakket', 'gezinnen', 'producten'));
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        $request->validate([
            'gezin_id' => 'required|exists:gezinnen,id',
            'pakket_nummer' => 'required|integer',
            'datum_samenstelling' => 'required|date',
            'datum_uitgifte' => 'nullable|date|after_or_equal:datum_samenstelling',
            'status' => 'required|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
        ]);

        $voedselpakket->update($request->all());

        // Sync producten with aantal
        $productSync = [];
        if ($request->has('product_data')) {
            foreach ($request->product_data as $productData) {
                if (isset($productData['product_id']) && isset($productData['aantal_product_eenheden'])) {
                    $productSync[$productData['product_id']] = [
                        'aantal_product_eenheden' => $productData['aantal_product_eenheden']
                    ];
                }
            }
        }
        $voedselpakket->producten()->sync($productSync);

        return redirect()->route('voedselpakketten.index')
            ->with('success', 'Voedselpakket succesvol bijgewerkt.');
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        $voedselpakket->delete();

        return redirect()->route('voedselpakketten.index')
            ->with('success', 'Voedselpakket succesvol verwijderd.');
    }
}
