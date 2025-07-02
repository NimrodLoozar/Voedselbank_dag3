<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Gezin;
use App\Models\Klanten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KlantenController extends Controller
{
    /**
     * Display a listing of all customers (gezinnen) with their contact information
     */
    public function index(Request $request)
    {
        try {
            $postcode = $request->get('postcode');
            $klanten = collect();
            $message = null;
            
            // Get all unique postcodes for the dropdown
            $postcodes = Contact::whereHas('gezinnen')
                ->distinct()
                ->orderBy('postcode')
                ->pluck('postcode')
                ->filter();

            // Add some test postcodes for demonstration purposes (postcodes outside Maaskantje region)
            $testPostcodes = collect(['1234AB', '5270AA', '3000BB', '6789CD']);
            $postcodes = $postcodes->merge($testPostcodes)->unique()->sort()->values();

            if ($postcode) {
                // Filter customers by postcode
                $klanten = Klanten::getKlantenByPostcode($postcode);
                
                if ($klanten->isEmpty()) {
                    $message = "Er zijn geen klanten bekend die de geselecteerde postcode hebben";
                }
            } else {
                // Show all customers when no postcode filter is applied
                $klanten = Klanten::getAllKlanten();
            }

            return view('klanten.index', compact('klanten', 'postcodes', 'postcode', 'message'));

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error loading customers: ' . $e->getMessage(), [
                'postcode' => $request->get('postcode'),
                'user_id' => auth()->id()
            ]);

            return view('klanten.index', [
                'klanten' => collect(),
                'postcodes' => collect(),
                'postcode' => null,
                'message' => 'Er is een fout opgetreden bij het laden van de klanten. Probeer het opnieuw.'
            ]);
        }
    }

    /**
     * Display the specified customer with detailed information
     */
    public function show($id)
    {
        try {
            $gezin = Gezin::with(['personen', 'contacts'])
                ->findOrFail($id);
            
            $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
            $contact = $gezin->contacts->first();
            
            return view('klanten.show', compact('gezin', 'vertegenwoordiger', 'contact'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('klanten.index')
                ->with('error', 'De geselecteerde klant kon niet worden gevonden')
                ->withErrors(['general' => 'Klant niet gevonden']);
        } catch (\Exception $e) {
            \Log::error('Error loading customer details: ' . $e->getMessage(), [
                'customer_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('klanten.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van de klantgegevens')
                ->withErrors(['general' => 'Onverwachte fout opgetreden']);
        }
    }

    /**
     * Show the form for editing the specified customer
     */
    public function edit($id)
    {
        try {
            $gezin = Gezin::with(['personen', 'contacts'])->findOrFail($id);
            $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
            $contact = $gezin->contacts->first();
            
            return view('klanten.edit', compact('gezin', 'vertegenwoordiger', 'contact'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('klanten.index')
                ->with('error', 'De geselecteerde klant kon niet worden gevonden')
                ->withErrors(['general' => 'Klant niet gevonden']);
        } catch (\Exception $e) {
            \Log::error('Error loading customer edit form: ' . $e->getMessage(), [
                'customer_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->route('klanten.index')
                ->with('error', 'Er is een fout opgetreden bij het laden van het wijzigingsformulier')
                ->withErrors(['general' => 'Onverwachte fout opgetreden']);
        }
    }

    /**
     * Update the specified customer in storage
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'vertegenwoordiger_voornaam' => 'required|string|max:255',
                'vertegenwoordiger_achternaam' => 'required|string|max:255',
                'vertegenwoordiger_tussenvoegsel' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'mobiel' => ['nullable', 'string', 'max:20', function ($attribute, $value, $fail) {
                    if ($value && !Klanten::isValidDutchMobile($value)) {
                        $fail('Het mobiele nummer moet een geldig Nederlands mobiel nummer zijn (bijv. 06xxxxxxxx of +31 6xxxxxxxx)');
                    }
                }],
                'straat' => 'nullable|string|max:255',
                'huisnummer' => 'nullable|integer|min:1|max:9999',
                'toevoeging' => 'nullable|string|max:10',
                'postcode' => ['nullable', 'string', 'max:10', function ($attribute, $value, $fail) {
                    if ($value && !Klanten::isValidMaaskantjePostcode($value)) {
                        $fail('De postcode komt niet uit de regio Maaskantje');
                    }
                }],
                'woonplaats' => 'nullable|string|max:255',
            ]);

            // Start database transaction
            DB::beginTransaction();

            // Check if postcode is being changed to a non-Maaskantje region
            $gezin = Gezin::findOrFail($id);
            $contact = $gezin->contacts->first();
            
            if ($request->postcode && $contact) {
                if (!Klanten::canUpdateContactDetails($contact->postcode, $request->postcode)) {
                    return redirect()->back()
                        ->withErrors([
                            'postcode' => 'De postcode komt niet uit de regio Maaskantje',
                            'general' => 'De contactgegevens van de geselecteerde klant kunnen niet gewijzigd worden'
                        ])
                        ->withInput();
                }
            }
            
            // Update vertegenwoordiger
            $vertegenwoordiger = $gezin->personen->where('is_vertegenwoordiger', true)->first();
            if ($vertegenwoordiger) {
                $vertegenwoordiger->update([
                    'voornaam' => $request->vertegenwoordiger_voornaam,
                    'tussenvoegsel' => $request->vertegenwoordiger_tussenvoegsel,
                    'achternaam' => $request->vertegenwoordiger_achternaam,
                ]);
            }

            // Update contact information
            if ($contact) {
                $contact->update([
                    'email' => $request->email,
                    'mobiel' => $request->mobiel,
                    'straat' => $request->straat,
                    'huisnummer' => $request->huisnummer,
                    'toevoeging' => $request->toevoeging,
                    'postcode' => $request->postcode,
                    'woonplaats' => $request->woonplaats,
                ]);
            }

            // Commit the transaction
            DB::commit();

            // Redirect back to edit page with success message and redirect flag
            return redirect()->route('klanten.edit', $gezin)
                ->with('success', 'De klantgegevens zijn gewijzigd')
                ->with('redirect_to_show', true);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors - let Laravel handle these normally
            throw $e;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Customer not found
            return redirect()->route('klanten.index')
                ->withErrors(['general' => 'De geselecteerde klant kon niet worden gevonden'])
                ->with('error', 'Klant niet gevonden');
        } catch (\Exception $e) {
            // Rollback transaction on any other error
            DB::rollback();
            
            // Log the error for debugging
            \Log::error('Error updating customer: ' . $e->getMessage(), [
                'customer_id' => $id,
                'user_id' => auth()->id(),
                'request_data' => $request->all()
            ]);

            return redirect()->back()
                ->withErrors(['general' => 'Er is een fout opgetreden bij het bijwerken van de klantgegevens. Probeer het opnieuw.'])
                ->withInput()
                ->with('error', 'Er is een onverwachte fout opgetreden');
        }
    }

    /**
     * Update customer using stored procedure (alternative approach)
     */
    public function updateWithStoredProcedure(Request $request, $id)
    {
        try {
            // Basic validation
            $request->validate([
                'vertegenwoordiger_voornaam' => 'required|string|max:255',
                'vertegenwoordiger_achternaam' => 'required|string|max:255',
                'vertegenwoordiger_tussenvoegsel' => 'nullable|string|max:255',
                'email' => 'nullable|email',
                'mobiel' => ['nullable', 'string', 'max:20', function ($attribute, $value, $fail) {
                    if ($value && !Klanten::isValidDutchMobile($value)) {
                        $fail('Het mobiele nummer moet een geldig Nederlands mobiel nummer zijn (bijv. 06xxxxxxxx of +31 6xxxxxxxx)');
                    }
                }],
                'straat' => 'nullable|string|max:255',
                'huisnummer' => 'nullable|integer|min:1|max:9999',
                'toevoeging' => 'nullable|string|max:10',
                'postcode' => ['nullable', 'string', 'max:10', function ($attribute, $value, $fail) {
                    if ($value && !Klanten::isValidMaaskantjePostcode($value)) {
                        $fail('De postcode komt niet uit de regio Maaskantje');
                    }
                }],
                'woonplaats' => 'nullable|string|max:255',
            ]);

            // Call stored procedure
            $result = DB::select('
                CALL UpdateCustomerInfo(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @success, @message);
                SELECT @success as success, @message as message;
            ', [
                $id,
                $request->vertegenwoordiger_voornaam,
                $request->vertegenwoordiger_tussenvoegsel,
                $request->vertegenwoordiger_achternaam,
                $request->email,
                $request->mobiel,
                $request->straat,
                $request->huisnummer,
                $request->toevoeging,
                $request->postcode,
                $request->woonplaats
            ]);

            // Get the result from the stored procedure
            $procedureResult = end($result);
            
            if ($procedureResult->success) {
                return redirect()->route('klanten.show', $id)
                    ->with('success', $procedureResult->message);
            } else {
                return redirect()->back()
                    ->withErrors(['general' => $procedureResult->message])
                    ->withInput();
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error('Error calling stored procedure: ' . $e->getMessage(), [
                'customer_id' => $id,
                'user_id' => auth()->id()
            ]);

            return redirect()->back()
                ->withErrors(['general' => 'Er is een onverwachte fout opgetreden'])
                ->withInput();
        }
    }
}