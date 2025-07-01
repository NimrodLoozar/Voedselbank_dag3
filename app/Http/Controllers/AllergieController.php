<?php

namespace App\Http\Controllers;

use App\Models\Allergie;
use Illuminate\Http\Request;

class AllergieController extends Controller
{
    public function index()
    {
        $allergies = Allergie::all();
        return view('allergies.index', compact('allergies'));
    }

    public function create()
    {
        return view('allergies.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string',
            'anafylactisch_risico' => 'required|in:zeerlaag,laag,redelijk_hoog,hoog'
        ]);

        Allergie::create($request->all());

        return redirect()->route('allergies.index')
            ->with('success', 'Allergie succesvol aangemaakt.');
    }

    public function show(Allergie $allergie)
    {
        return view('allergies.show', compact('allergie'));
    }

    public function edit(Allergie $allergie)
    {
        return view('allergies.edit', compact('allergie'));
    }

    public function update(Request $request, Allergie $allergie)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string',
            'anafylactisch_risico' => 'required|in:zeerlaag,laag,redelijk_hoog,hoog'
        ]);

        $allergie->update($request->all());

        return redirect()->route('allergies.index')
            ->with('success', 'Allergie succesvol bijgewerkt.');
    }

    public function destroy(Allergie $allergie)
    {
        $allergie->delete();

        return redirect()->route('allergies.index')
            ->with('success', 'Allergie succesvol verwijderd.');
    }
}
