<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function index()
    {
        $rollen = Rol::all();
        return view('rollen.index', compact('rollen'));
    }

    public function create()
    {
        return view('rollen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255'
        ]);

        Rol::create($request->all());

        return redirect()->route('rollen.index')
            ->with('success', 'Rol succesvol aangemaakt.');
    }

    public function show(Rol $rol)
    {
        return view('rollen.show', compact('rol'));
    }

    public function edit(Rol $rol)
    {
        return view('rollen.edit', compact('rol'));
    }

    public function update(Request $request, Rol $rol)
    {
        $request->validate([
            'naam' => 'required|string|max:255'
        ]);

        $rol->update($request->all());

        return redirect()->route('rollen.index')
            ->with('success', 'Rol succesvol bijgewerkt.');
    }

    public function destroy(Rol $rol)
    {
        $rol->delete();

        return redirect()->route('rollen.index')
            ->with('success', 'Rol succesvol verwijderd.');
    }
}
