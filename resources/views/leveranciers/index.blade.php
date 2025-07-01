<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Header and Filter Row -->
                    <div class="mb-6 flex justify-between items-center">
                        <h2 class="font-semibold text-xl text-green-600 dark:text-green-400 leading-tight underline">
                            {{ __('Overzicht Leveranciers') }}
                        </h2>
                        <div class="flex-1 flex justify-end pr-8">
                            <form method="GET" action="{{ route('leveranciers.index') }}" class="flex items-center gap-2">
                                <div class="relative">
                                    <select name="leverancier_type" class="rounded-md border border-gray-300 dark:border-gray-500 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm py-2 pl-3 pr-10 focus:ring-1 focus:ring-blue-400 focus:border-blue-400 outline-none min-w-[200px] appearance-none">
                                        <option value="">Selecteer Leveranciertype</option>
                                        <option value="Bedrijf" {{ request('leverancier_type') == 'Bedrijf' ? 'selected' : '' }}>Bedrijf</option>
                                        <option value="Instelling" {{ request('leverancier_type') == 'Instelling' ? 'selected' : '' }}>Instelling</option>
                                        <option value="Overheid" {{ request('leverancier_type') == 'Overheid' ? 'selected' : '' }}>Overheid</option>
                                        <option value="Particulier" {{ request('leverancier_type') == 'Particulier' ? 'selected' : '' }}>Particulier</option>
                                        <option value="Donor" {{ request('leverancier_type') == 'Donor' ? 'selected' : '' }}>Donor</option>
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150">
                                    Toon Leveranciers
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- CSRF-token toevoegen, heeft geen effect in een GET-view, maar kan geen kwaad --}}
                    <form style="display:none;">@csrf</form>

                    <!-- Leveranciers Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-300 dark:border-gray-600">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Naam</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Contactpersoon</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">E-mail</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Mobiel</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Leveranciernummer</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">LeverancierType</th>
                                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Product Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                @if($leveranciers->count() === 0)
                                    <tr>
                                        <td colspan="7" style="background: #fff8dc; color: #856404; text-align: center; padding: 24px; font-size: 1.1rem; border-radius: 8px;">
                                            Er zijn geen leveranciers bekent van het geselecteerde leverancierstype
                                        </td>
                                    </tr>
                                @else
                                    @foreach($leveranciers as $leverancier)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->naam }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->contact_persoon }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->contacts[0]->email ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->contacts[0]->mobiel ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->leverancier_nummer }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $leverancier->leverancier_type }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                <a href="{{ route('leveranciers.show', $leverancier->id) }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Home Button -->
                    <div class="mt-6 flex justify-end">
                        <a href="{{ route('/') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>