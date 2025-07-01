<?php

namespace App\Http\Controllers;

use App\Models\Persoon;
use App\Models\Gezin;
use App\Models\Allergie;
use Illuminate\Http\Request;

class PersoonController extends Controller
{
    public function index()
    {
        $personen = Persoon::with(['gezin', 'allergies', 'gebruiker'])->get();
        return view('personen.index', compact('personen'));
    }

    public function create()
    {
        $gezinnen = Gezin::all();
        $allergies = Allergie::all();
        return view('personen.create', compact('gezinnen', 'allergies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gezin_id' => 'nullable|exists:gezinnen,id',
            'voornaam' => 'required|string|max:255',
            'tussenvoegsel' => 'nullable|string|max:50',
            'achternaam' => 'required|string|max:255',
            'geboortedatum' => 'required|date',
            'type_persoon' => 'required|in:Manager,Medewerker,Vrijwilliger,Klant',
            'is_vertegenwoordiger' => 'boolean'
        ]);

        $persoon = Persoon::create($request->all());

        if ($request->has('allergie_ids')) {
            $persoon->allergies()->attach($request->allergie_ids);
        }

        return redirect()->route('personen.index')
            ->with('success', 'Persoon succesvol aangemaakt.');
    }

    public function show(Persoon $persoon)
    {
        $persoon->load(['gezin', 'allergies', 'gebruiker']);
        return view('personen.show', compact('persoon'));
    }

    public function edit(Persoon $persoon)
    {
        $gezinnen = Gezin::all();
        $allergies = Allergie::all();
        return view('personen.edit', compact('persoon', 'gezinnen', 'allergies'));
    }

    public function update(Request $request, Persoon $persoon)
    {
        $request->validate([
            'gezin_id' => 'nullable|exists:gezinnen,id',
            'voornaam' => 'required|string|max:255',
            'tussenvoegsel' => 'nullable|string|max:50',
            'achternaam' => 'required|string|max:255',
            'geboortedatum' => 'required|date',
            'type_persoon' => 'required|in:Manager,Medewerker,Vrijwilliger,Klant',
            'is_vertegenwoordiger' => 'boolean'
        ]);

        $persoon->update($request->all());

        $persoon->allergies()->sync($request->allergie_ids ?? []);

        return redirect()->route('personen.index')
            ->with('success', 'Persoon succesvol bijgewerkt.');
    }

    public function destroy(Persoon $persoon)
    {
        $persoon->delete();

        return redirect()->route('personen.index')
            ->with('success', 'Persoon succesvol verwijderd.');
    }
}
