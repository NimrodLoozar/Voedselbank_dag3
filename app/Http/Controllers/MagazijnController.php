<?php

namespace App\Http\Controllers;

use App\Models\Magazijn;
use Illuminate\Http\Request;

class MagazijnController extends Controller
{
    public function index()
    {
        $magazijnen = Magazijn::with('producten')->get();
        return view('magazijnen.index', compact('magazijnen'));
    }

    public function create()
    {
        return view('magazijnen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'ontvangstdatum' => 'required|date',
            'uitleveringsdatum' => 'nullable|date|after:ontvangstdatum',
            'verpakkings_eenheid' => 'required|string|max:255',
            'aantal' => 'required|integer|min:1'
        ]);

        Magazijn::create($request->all());

        return redirect()->route('magazijnen.index')
            ->with('success', 'Magazijn succesvol aangemaakt.');
    }

    public function show(Magazijn $magazijn)
    {
        $magazijn->load('producten');
        return view('magazijnen.show', compact('magazijn'));
    }

    public function edit(Magazijn $magazijn)
    {
        return view('magazijnen.edit', compact('magazijn'));
    }

    public function update(Request $request, Magazijn $magazijn)
    {
        $request->validate([
            'ontvangstdatum' => 'required|date',
            'uitleveringsdatum' => 'nullable|date|after:ontvangstdatum',
            'verpakkings_eenheid' => 'required|string|max:255',
            'aantal' => 'required|integer|min:1'
        ]);

        $magazijn->update($request->all());

        return redirect()->route('magazijnen.index')
            ->with('success', 'Magazijn succesvol bijgewerkt.');
    }

    public function destroy(Magazijn $magazijn)
    {
        $magazijn->delete();

        return redirect()->route('magazijnen.index')
            ->with('success', 'Magazijn succesvol verwijderd.');
    }
}
