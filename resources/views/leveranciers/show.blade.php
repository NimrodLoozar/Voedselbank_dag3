<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Page Title -->
                    <h1 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-8 border-b-2 border-green-600 pb-2">
                        Overzicht producten
                    </h1>

                    <!-- Leverancier Information Form -->
                    <div class="mb-8">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Naam:</label>
                                <div class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    {{ $leverancier->naam }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Leveranciernummer:</label>
                                <div class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    {{ $leverancier->leverancier_nummer }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Leveranciertype:</label>
                                <div class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                    {{ $leverancier->leverancier_type }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Products Table -->
                    @if($leverancier->producten && $leverancier->producten->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full border border-gray-300 dark:border-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Naam</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Soort Allergie</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Barcode</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-300 dark:border-gray-600">Houdbaarheidsdatum</th>
                                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700 dark:text-gray-300">Wijzig Product</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-600">
                                    @foreach($leverancier->producten as $product)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $product->naam }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $product->soort_allergie ?: '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $product->barcode }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100 border-r border-gray-300 dark:border-gray-600">
                                                {{ $product->houdbaarheidsdatum ? $product->houdbaarheidsdatum->format('d-m-Y') : '-' }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                <a href="#" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">Geen producten beschikbaar voor deze leverancier.</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end gap-4">
                        <a href="{{ route('leveranciers.index') }}" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                            terug
                        </a>
                        <a href="{{ route('/') }}" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                            home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
