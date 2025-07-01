<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Overzicht Klanten') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header with inline postcode filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Overzicht Klanten</h1>
                        
                        <form method="GET" action="{{ route('klanten.index') }}" class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <label for="postcode" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                    Selecteer Postcode
                                </label>
                                <select name="postcode" id="postcode" class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleManualInput()">
                                    <option value="">-- Alle postcodes --</option>
                                    @foreach($postcodes as $pc)
                                        <option value="{{ $pc }}" {{ $postcode == $pc ? 'selected' : '' }}>
                                            {{ $pc }}
                                        </option>
                                    @endforeach
                                    <option value="custom" {{ $postcode && !in_array($postcode, $postcodes->toArray()) ? 'selected' : '' }}>-- Voer handmatig in --</option>
                                </select>
                            </div>
                            
                            <div id="manual-input" style="display: {{ $postcode && !in_array($postcode, $postcodes->toArray()) ? 'flex' : 'none' }};" class="items-center gap-2">
                                <input type="text" name="manual_postcode" id="manual_postcode" 
                                       value="{{ $postcode && !in_array($postcode, $postcodes->toArray()) ? $postcode : '' }}"
                                       placeholder="bijv. 1234AB"
                                       class="rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            
                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 whitespace-nowrap">
                                Toon Klanten
                            </button>
                            
                            @if($postcode)
                                <a href="{{ route('klanten.index') }}" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 whitespace-nowrap">
                                    Reset Filter
                                </a>
                            @endif
                        </form>
                    </div>

            <!-- Message Display -->
            @if($message)
                <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $message }}
                    </div>
                </div>
            @endif

            <!-- Klanten Table -->
            @if($klanten->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Naam Gezin
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Vertegenwoordiger
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            E-mailadres
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Mobiel
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Adres
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Woonplaats
                                        </th>
                                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Klant Details
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($klanten as $klant)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100 max-w-24 truncate" title="{{ $klant->gezin_naam }}">
                                                    {{ $klant->gezin_naam }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $klant->gezin_code }}
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100 max-w-28 truncate" title="{{ $klant->vertegenwoordiger_naam }}">
                                                    {{ $klant->vertegenwoordiger_naam }}
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if($klant->email)
                                                        <div class="max-w-32 truncate">
                                                            <a href="mailto:{{ $klant->email }}" class="text-blue-600 hover:text-blue-800 text-xs" title="{{ $klant->email }}">{{ Str::limit($klant->email, 18) }}</a>
                                                        </div>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400 italic text-xs">Geen email</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if($klant->mobiel)
                                                        <a href="tel:{{ $klant->mobiel }}" class="text-blue-600 hover:text-blue-800 text-xs">{{ $klant->mobiel }}</a>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400 italic text-xs">Geen mobiel</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-4">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if($klant->straat)
                                                        <div class="max-w-28 truncate" title="{{ $klant->straat }} {{ $klant->huisnummer }}{{ $klant->toevoeging }}">
                                                            <span class="text-xs">{{ Str::limit($klant->straat, 12) }} {{ $klant->huisnummer }}{{ $klant->toevoeging }}</span>
                                                        </div>
                                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $klant->postcode }}</div>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400 italic text-xs">Geen adres</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    @if($klant->woonplaats)
                                                        <div class="max-w-20 truncate text-xs" title="{{ $klant->woonplaats }}">
                                                            {{ $klant->woonplaats }}
                                                        </div>
                                                    @else
                                                        <span class="text-gray-500 dark:text-gray-400 italic text-xs">Onbekend</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('klanten.show', $klant->gezin_id) }}" 
                                                   class="inline-flex items-center justify-center p-1 text-blue-600 hover:text-blue-800 transition-colors duration-200"
                                                   title="Bekijk klant details">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                </div>
            @elseif(!$message)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-gray-500 dark:text-gray-400">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Geen klanten gevonden</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Er zijn momenteel geen klanten geregistreerd.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleManualInput() {
            const select = document.getElementById('postcode');
            const manualDiv = document.getElementById('manual-input');
            const manualInput = document.getElementById('manual_postcode');
            
            if (select.value === 'custom') {
                manualDiv.style.display = 'flex';
                manualInput.focus();
            } else {
                manualDiv.style.display = 'none';
                manualInput.value = '';
            }
        }

        // Handle form submission to use manual input when selected
        document.querySelector('form').addEventListener('submit', function(e) {
            const select = document.getElementById('postcode');
            const manualInput = document.getElementById('manual_postcode');
            
            if (select.value === 'custom' && manualInput.value) {
                // Create a hidden input with the manual postcode value
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'postcode';
                hiddenInput.value = manualInput.value;
                this.appendChild(hiddenInput);
                
                // Remove the select name to avoid conflicts
                select.name = '';
            }
        });
    </script>
</x-app-layout>
