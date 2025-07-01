<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Gezin;
use App\Models\Product;
use App\Models\Eetwens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VoedselpakketController extends Controller
{
    public function index(Request $request)
    {
        $eetwensId = $request->get('eetwens_id') ?: null;
        $voedselpakketten = DB::select('CALL SP_GetVoedselPakkettenByGezin(?)', [$eetwensId]);
        $eetwensen = Eetwens::all();
        return view('voedselpakketten.index', compact('voedselpakketten', 'eetwensen'));
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
        $voedselpakketData = DB::select('CALL SP_GetVoedselPakketten(?)', [$voedselpakket->id]);
        $voedselpakketInfo = $voedselpakketData[0] ?? null;
        return view('voedselpakketten.show', compact('voedselpakketInfo'));
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        // Load relationships for the view
        $voedselpakket->load(['gezin', 'producten']);
        $pakket = $voedselpakket; // Alias to match view variable
        
        return view('voedselpakketten.edit', compact('pakket', 'voedselpakket'));
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        // Validate only the status if it's a simple status update
        if ($request->has('status') && count($request->all()) <= 3) { // _token, _method, status
            $request->validate([
                'status' => 'required|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
            ]);
            
            $updateData = ['status' => $request->status];
            
            // Set datum_uitgifte to today if status is changed to 'Uitgereikt'
            if ($request->status === 'Uitgereikt') {
                $updateData['datum_uitgifte'] = now()->format('Y-m-d');
            }
            
            $voedselpakket->update($updateData);
            
            return redirect()->back()
                ->with('success', 'De wijziging is doorgevoerd');
        }
        
        // Full validation for complete form updates
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
