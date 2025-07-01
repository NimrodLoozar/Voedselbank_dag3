<?php

namespace App\Http\Controllers;

use App\Models\Leverancier;
use App\Models\Contact;
use Illuminate\Http\Request;

class LeverancierController extends Controller
{
    public function index(Request $request)
    {
        $query = Leverancier::with('contacts');
        
        // Filter op leveranciertype als er een is geselecteerd
        if ($request->filled('leverancier_type')) {
            $query->where('leverancier_type', $request->leverancier_type);
        }
        
        $leveranciers = $query->orderBy('naam')->get();
        
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

    public function show(Leverancier $leverancier)
    {
        $leverancier->load(['contacts', 'producten']);
        return view('leveranciers.show', compact('leverancier'));
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
