<?php

namespace App\Http\Controllers;

use App\Models\Voedselpakket;
use App\Models\Gezin;
use App\Models\Product;
use App\Models\Eetwens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VoedselpakketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $eetwensId = $request->get('eetwens_id') ?: null;
            $voedselpakketten = DB::select('CALL SP_GetVoedselPakkettenByGezin(?)', [$eetwensId]);
            $eetwensen = Eetwens::all();
            return view('voedselpakketten.index', compact('voedselpakketten', 'eetwensen'));
        } catch (\Exception $e) {
            Log::error('Error fetching voedselpakketten', ['error' => $e->getMessage(), 'eetwens_id' => $eetwensId]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van de voedselpakketten.');
        }
    }

    public function create()
    {
        try {
            $gezinnen = Gezin::all();
            $producten = Product::where('status', 'OpVoorraad')->get();
            return view('voedselpakketten.create', compact('gezinnen', 'producten'));
        } catch (\Exception $e) {
            Log::error('Error loading create form', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het formulier.');
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'gezin_id' => 'required|exists:gezinnen,id',
                'pakket_nummer' => 'required|integer',
                'datum_samenstelling' => 'required|date',
                'datum_uitgifte' => 'nullable|date|after_or_equal:datum_samenstelling',
                'status' => 'required|in:Uitgereikt,NietUitgereikt,NietMeerIngeschreven'
            ]);

            DB::beginTransaction();

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

            DB::commit();
            
            Log::info('Voedselpakket created successfully', ['voedselpakket_id' => $voedselpakket->id, 'gezin_id' => $request->gezin_id]);

            return redirect()->route('voedselpakketten.index')
                ->with('success', 'Voedselpakket succesvol aangemaakt.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating voedselpakket', ['error' => $e->getMessage(), 'request_data' => $request->all()]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het aanmaken van het voedselpakket.');
        }
    }

    public function show(Voedselpakket $voedselpakket)
    {
        try {
            $voedselpakketData = DB::select('CALL SP_GetVoedselPakketten(?)', [$voedselpakket->id]);
            $voedselpakketInfo = $voedselpakketData[0] ?? null;
            return view('voedselpakketten.show', compact('voedselpakketInfo'));
        } catch (\Exception $e) {
            Log::error('Error fetching voedselpakket details', ['error' => $e->getMessage(), 'voedselpakket_id' => $voedselpakket->id]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het ophalen van het voedselpakket.');
        }
    }

    public function edit(Voedselpakket $voedselpakket)
    {
        try {
            // Load relationships for the view
            $voedselpakket->load(['gezin', 'producten']);
            $pakket = $voedselpakket; // Alias to match view variable
            
            return view('voedselpakketten.edit', compact('pakket', 'voedselpakket'));
        } catch (\Exception $e) {
            Log::error('Error loading edit form', ['error' => $e->getMessage(), 'voedselpakket_id' => $voedselpakket->id]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het laden van het bewerkingsformulier.');
        }
    }

    public function update(Request $request, Voedselpakket $voedselpakket)
    {
        try {
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
                
                Log::info('Voedselpakket status updated', ['voedselpakket_id' => $voedselpakket->id, 'new_status' => $request->status]);
                
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

            DB::beginTransaction();

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

            DB::commit();
            
            Log::info('Voedselpakket updated successfully', ['voedselpakket_id' => $voedselpakket->id]);

            return redirect()->route('voedselpakketten.index')
                ->with('success', 'Voedselpakket succesvol bijgewerkt.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating voedselpakket', ['error' => $e->getMessage(), 'voedselpakket_id' => $voedselpakket->id, 'request_data' => $request->all()]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het bijwerken van het voedselpakket.');
        }
    }

    public function destroy(Voedselpakket $voedselpakket)
    {
        try {
            $voedselpakketId = $voedselpakket->id;
            $voedselpakket->delete();

            Log::info('Voedselpakket deleted successfully', ['voedselpakket_id' => $voedselpakketId]);

            return redirect()->route('voedselpakketten.index')
                ->with('success', 'Voedselpakket succesvol verwijderd.');
        } catch (\Exception $e) {
            Log::error('Error deleting voedselpakket', ['error' => $e->getMessage(), 'voedselpakket_id' => $voedselpakket->id]);
            return redirect()->back()->with('error', 'Er is een fout opgetreden bij het verwijderen van het voedselpakket.');
        }
    }
}
