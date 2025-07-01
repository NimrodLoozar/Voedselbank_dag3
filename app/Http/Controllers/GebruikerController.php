<?php

namespace App\Http\Controllers;

use App\Models\Gebruiker;
use App\Models\Persoon;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GebruikerController extends Controller
{
    public function index()
    {
        $gebruikers = Gebruiker::with(['persoon', 'rollen'])->get();
        return view('gebruikers.index', compact('gebruikers'));
    }

    public function create()
    {
        $personen = Persoon::whereDoesntHave('gebruiker')->get();
        $rollen = Rol::all();
        return view('gebruikers.create', compact('personen', 'rollen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'persoon_id' => 'required|exists:personen,id|unique:gebruikers',
            'inlog_naam' => 'required|string|max:255',
            'gebruikersnaam' => 'required|string|max:255|unique:gebruikers',
            'wachtwoord' => 'required|string|min:8',
            'is_ingelogd' => 'boolean'
        ]);

        $gebruiker = Gebruiker::create([
            'persoon_id' => $request->persoon_id,
            'inlog_naam' => $request->inlog_naam,
            'gebruikersnaam' => $request->gebruikersnaam,
            'wachtwoord' => Hash::make($request->wachtwoord),
            'is_ingelogd' => $request->is_ingelogd ?? false
        ]);

        if ($request->has('rol_ids')) {
            $gebruiker->rollen()->attach($request->rol_ids);
        }

        return redirect()->route('gebruikers.index')
            ->with('success', 'Gebruiker succesvol aangemaakt.');
    }

    public function show(Gebruiker $gebruiker)
    {
        $gebruiker->load(['persoon', 'rollen']);
        return view('gebruikers.show', compact('gebruiker'));
    }

    public function edit(Gebruiker $gebruiker)
    {
        $personen = Persoon::whereDoesntHave('gebruiker')
            ->orWhere('id', $gebruiker->persoon_id)
            ->get();
        $rollen = Rol::all();
        return view('gebruikers.edit', compact('gebruiker', 'personen', 'rollen'));
    }

    public function update(Request $request, Gebruiker $gebruiker)
    {
        $request->validate([
            'persoon_id' => 'required|exists:personen,id|unique:gebruikers,persoon_id,' . $gebruiker->id,
            'inlog_naam' => 'required|string|max:255',
            'gebruikersnaam' => 'required|string|max:255|unique:gebruikers,gebruikersnaam,' . $gebruiker->id,
            'wachtwoord' => 'nullable|string|min:8',
            'is_ingelogd' => 'boolean'
        ]);

        $updateData = [
            'persoon_id' => $request->persoon_id,
            'inlog_naam' => $request->inlog_naam,
            'gebruikersnaam' => $request->gebruikersnaam,
            'is_ingelogd' => $request->is_ingelogd ?? false
        ];

        if ($request->filled('wachtwoord')) {
            $updateData['wachtwoord'] = Hash::make($request->wachtwoord);
        }

        $gebruiker->update($updateData);

        $gebruiker->rollen()->sync($request->rol_ids ?? []);

        return redirect()->route('gebruikers.index')
            ->with('success', 'Gebruiker succesvol bijgewerkt.');
    }

    public function destroy(Gebruiker $gebruiker)
    {
        $gebruiker->delete();

        return redirect()->route('gebruikers.index')
            ->with('success', 'Gebruiker succesvol verwijderd.');
    }
}
