<?php

namespace App\Http\Controllers;

use App\Models\Eetwens;
use Illuminate\Http\Request;

class EetwensController extends Controller
{
    public function index()
    {
        $eetwensen = Eetwens::all();
        return view('eetwensen.index', compact('eetwensen'));
    }

    public function create()
    {
        return view('eetwensen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string'
        ]);

        Eetwens::create($request->all());

        return redirect()->route('eetwensen.index')
            ->with('success', 'Eetwens succesvol aangemaakt.');
    }

    public function show(Eetwens $eetwens)
    {
        return view('eetwensen.show', compact('eetwens'));
    }

    public function edit(Eetwens $eetwens)
    {
        return view('eetwensen.edit', compact('eetwens'));
    }

    public function update(Request $request, Eetwens $eetwens)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string'
        ]);

        $eetwens->update($request->all());

        return redirect()->route('eetwensen.index')
            ->with('success', 'Eetwens succesvol bijgewerkt.');
    }

    public function destroy(Eetwens $eetwens)
    {
        $eetwens->delete();

        return redirect()->route('eetwensen.index')
            ->with('success', 'Eetwens succesvol verwijderd.');
    }
}
