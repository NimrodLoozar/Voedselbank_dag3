<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string'
        ]);

        Categorie::create($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Categorie succesvol aangemaakt.');
    }

    public function show(Categorie $categorie)
    {
        return view('categories.show', compact('categorie'));
    }

    public function edit(Categorie $categorie)
    {
        return view('categories.edit', compact('categorie'));
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'omschrijving' => 'required|string'
        ]);

        $categorie->update($request->all());

        return redirect()->route('categories.index')
            ->with('success', 'Categorie succesvol bijgewerkt.');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Categorie succesvol verwijderd.');
    }
}
