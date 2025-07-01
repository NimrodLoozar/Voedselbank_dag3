<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Leverancier Details') }} - {{ $leverancier->naam }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('leveranciers.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                            </svg>
                            Terug naar overzicht
                        </a>
                    </div>

                    <!-- Leverancier Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Basic Info -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Leverancier Informatie
                            </h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Naam</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leverancier->naam }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Contactpersoon</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leverancier->contact_persoon }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Leverancier Nummer</label>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $leverancier->leverancier_nummer }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Type</label>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($leverancier->leverancier_type == 'Bedrijf') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($leverancier->leverancier_type == 'Instelling') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($leverancier->leverancier_type == 'Overheid') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        @elseif($leverancier->leverancier_type == 'Particulier') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        @elseif($leverancier->leverancier_type == 'Donor') bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200
                                        @endif">
                                        {{ $leverancier->leverancier_type }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Contact Gegevens
                            </h3>
                            @if($leverancier->contacts && $leverancier->contacts->count() > 0)
                                <div class="space-y-4">
                                    @foreach($leverancier->contacts as $contact)
                                        <div class="border-b border-gray-200 dark:border-gray-600 pb-3 last:border-b-0">
                                            <div class="space-y-2">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                            {{ $contact->email }}
                                                        </a>
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Telefoon</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                        <a href="tel:{{ $contact->telefoon }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                            {{ $contact->telefoon }}
                                                        </a>
                                                    </p>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobiel</label>
                                                    <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                                        <a href="tel:{{ $contact->mobiel }}" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                            {{ $contact->mobiel }}
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">Geen contactgegevens beschikbaar.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Products Section -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                            Geleverde Producten
                        </h3>
                        @if($leverancier->producten && $leverancier->producten->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-100 dark:bg-gray-600">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Categorie</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Barcode</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Houdbaarheidsdatum</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach($leverancier->producten as $product)
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $product->naam }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $product->categorie->naam ?? '-' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $product->barcode }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                        @if($product->status == 'OpVoorraad') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                        @elseif($product->status == 'UitVoorraad') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                                        @endif">
                                                        {{ $product->status }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                                    {{ $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('d-m-Y') : '-' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m13-8l-4 4-4-4M9 5v12"></path>
                                </svg>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">Geen producten</h3>
                                <p class="text-gray-500 dark:text-gray-400">Deze leverancier heeft nog geen producten geleverd.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('leveranciers.index') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                            </svg>
                            Terug naar overzicht
                        </a>
                        <a href="{{ route('/') }}" 
                           class="inline-flex items-center justify-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition duration-150">
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
