<?php

namespace App\Http\Controllers;

use App\Models\Gezin;
use App\Models\Contact;
use App\Models\Eetwens;
use Illuminate\Http\Request;

class GezinController extends Controller
{
    public function index()
    {
        $gezinnen = Gezin::with(['contacts', 'eetwensen', 'personen'])->get();
        return view('gezinnen.index', compact('gezinnen'));
    }

    public function create()
    {
        $contacts = Contact::all();
        $eetwensen = Eetwens::all();
        return view('gezinnen.create', compact('contacts', 'eetwensen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:gezinnen',
            'omschrijving' => 'required|string',
            'aantal_volwassenen' => 'required|integer|min:0',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babys' => 'required|integer|min:0',
            'totaal_aantal_personen' => 'required|integer|min:1'
        ]);

        $gezin = Gezin::create($request->all());

        if ($request->has('contact_ids')) {
            $gezin->contacts()->attach($request->contact_ids);
        }

        if ($request->has('eetwens_ids')) {
            $gezin->eetwensen()->attach($request->eetwens_ids);
        }

        return redirect()->route('gezinnen.index')
            ->with('success', 'Gezin succesvol aangemaakt.');
    }

    public function show(Gezin $gezin)
    {
        $gezin->load(['contacts', 'eetwensen', 'personen', 'voedselpakketten']);
        return view('gezinnen.show', compact('gezin'));
    }

    public function edit(Gezin $gezin)
    {
        $contacts = Contact::all();
        $eetwensen = Eetwens::all();
        return view('gezinnen.edit', compact('gezin', 'contacts', 'eetwensen'));
    }

    public function update(Request $request, Gezin $gezin)
    {
        $request->validate([
            'naam' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:gezinnen,code,' . $gezin->id,
            'omschrijving' => 'required|string',
            'aantal_volwassenen' => 'required|integer|min:0',
            'aantal_kinderen' => 'required|integer|min:0',
            'aantal_babys' => 'required|integer|min:0',
            'totaal_aantal_personen' => 'required|integer|min:1'
        ]);

        $gezin->update($request->all());

        $gezin->contacts()->sync($request->contact_ids ?? []);
        $gezin->eetwensen()->sync($request->eetwens_ids ?? []);

        return redirect()->route('gezinnen.index')
            ->with('success', 'Gezin succesvol bijgewerkt.');
    }

    public function destroy(Gezin $gezin)
    {
        $gezin->delete();

        return redirect()->route('gezinnen.index')
            ->with('success', 'Gezin succesvol verwijderd.');
    }
}
