<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('contacts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'straat' => 'required|string|max:255',
            'huisnummer' => 'required|string|max:10',
            'toevoeging' => 'nullable|string|max:10',
            'postcode' => 'required|string|max:10',
            'woonplaats' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobiel' => 'required|string|max:20'
        ]);

        Contact::create($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact succesvol aangemaakt.');
    }

    public function show(Contact $contact)
    {
        return view('contacts.show', compact('contact'));
    }

    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'straat' => 'required|string|max:255',
            'huisnummer' => 'required|string|max:10',
            'toevoeging' => 'nullable|string|max:10',
            'postcode' => 'required|string|max:10',
            'woonplaats' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobiel' => 'required|string|max:20'
        ]);

        $contact->update($request->all());

        return redirect()->route('contacts.index')
            ->with('success', 'Contact succesvol bijgewerkt.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('contacts.index')
            ->with('success', 'Contact succesvol verwijderd.');
    }
}
