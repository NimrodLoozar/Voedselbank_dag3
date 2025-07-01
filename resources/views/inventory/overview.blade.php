<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Overzicht Productvoorraden') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-3 sm:p-4 rounded mb-4 flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2 mt-0.5 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-3 sm:p-4 rounded mb-4 flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 mr-2 mt-0.5 flex-shrink-0"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span class="text-sm sm:text-base">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Category Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Filter op Productcategorie
                    </h3>

                    <form action="{{ route('inventory.overview') }}" method="GET"
                        class="flex flex-col sm:flex-row sm:flex-wrap items-stretch sm:items-end gap-4">

                        <div class="flex-1 min-w-full sm:min-w-64">
                            <label for="categorie_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Selecteer Productgroep
                            </label>
                            <select name="categorie_id" id="categorie_id"
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                <option value="">-- Selecteer een categorie --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'selected' : '' }}>
                                        {{ $category->naam }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                                Toon Voorraad
                            </button>

                            <a href="{{ route('inventory.overview') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline text-center">
                                Toon Alle Producten
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Inventory Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Voorraadproducten
                            @if (isset($categorie))
                                - {{ $categorie->naam }}
                            @endif
                        </h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Totaal: {{ $producten->total() }} {{ $producten->total() === 1 ? 'product' : 'producten' }}
                            <span class="hidden sm:inline">
                                ({{ $producten->firstItem() ?? 0 }}-{{ $producten->lastItem() ?? 0 }} van
                                {{ $producten->total() }})
                            </span>
                        </div>
                    </div>

                    @if ($producten->count() > 0)
                        <!-- Mobile Card View (hidden on desktop) -->
                        <div class="block sm:hidden space-y-4">
                            @foreach ($producten as $product)
                                <div
                                    class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-gray-50 dark:bg-gray-700">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->naam }}
                                            </h4>
                                            @if ($product->omschrijving)
                                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                                    {{ Str::limit($product->omschrijving, 60) }}
                                                </p>
                                            @endif
                                        </div>
                                        <a href="{{ route('inventory.details', $product) }}"
                                            class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 ml-2"
                                            title="Bekijk details">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>

                                    <div class="grid grid-cols-2 gap-3 text-sm">
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Categorie:</span>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->categorie->naam ?? 'Onbekend' }}
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Aantal:</span>
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                @if ($product->magazijnen->count() > 0)
                                                    {{ $product->magazijnen->sum('aantal') }}
                                                    <span class="text-xs text-gray-500">
                                                        {{ $product->magazijnen->first()->verpakkings_eenheid ?? '' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">0</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Houdbaar tot:</span>
                                            @php
                                                $isExpired = $product->houdbaarheidsdatum < now();
                                                $isExpiringSoon = $product->houdbaarheidsdatum < now()->addDays(7);
                                            @endphp
                                            <div
                                                class="font-medium {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-yellow-600' : 'text-gray-900 dark:text-gray-100') }}">
                                                {{ $product->houdbaarheidsdatum->format('d-m-Y') }}
                                            </div>
                                        </div>
                                        <div>
                                            <span class="text-gray-500 dark:text-gray-400">Locatie:</span>
                                            <div>
                                                @if ($product->magazijnen->count() > 0)
                                                    @foreach ($product->magazijnen as $magazijn)
                                                        <span
                                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 mr-1 mb-1">
                                                            {{ $magazijn->pivot->locatie ?? 'Onbekend' }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400 text-xs">Geen locatie</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table View (hidden on mobile) -->
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Productnaam
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Eenheid
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aantal
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Houdbaarheidsdatum
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Magazijn
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Voorraad Details
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($producten as $product)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $product->naam }}
                                                </div>
                                                @if ($product->omschrijving)
                                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                                        {{ Str::limit($product->omschrijving, 50) }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->categorie->naam ?? 'Onbekend' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                @if ($product->magazijnen->count() > 0)
                                                    {{ $product->magazijnen->first()->verpakkings_eenheid ?? 'Onbekend' }}
                                                @else
                                                    <span class="text-gray-400">Onbekend</span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                @if ($product->magazijnen->count() > 0)
                                                    {{ $product->magazijnen->sum('aantal') }}
                                                @else
                                                    <span class="text-gray-400">0</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $isExpired = $product->houdbaarheidsdatum < now();
                                                    $isExpiringSoon = $product->houdbaarheidsdatum < now()->addDays(7);
                                                @endphp
                                                <span
                                                    class="{{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-yellow-600' : 'text-gray-900 dark:text-gray-100') }}">
                                                    {{ $product->houdbaarheidsdatum->format('d-m-Y') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                @if ($product->magazijnen->count() > 0)
                                                    @foreach ($product->magazijnen as $magazijn)
                                                        <div class="mb-1">
                                                            <span
                                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">
                                                                {{ $magazijn->pivot->locatie ?? 'Onbekend' }}
                                                            </span>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="text-gray-400">Geen locatie</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('inventory.details', $product) }}"
                                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300"
                                                    title="Bekijk details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Links -->
                        <div class="mt-6">
                            {{ $producten->appends(request()->query())->links() }}
                        </div>
                    @else
                        @if (isset($selectedCategory) && $selectedCategory)
                            <!-- Error message for no products in selected category -->
                            <div class="bg-red-500 text-white p-3 sm:p-4 rounded mb-4 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 sm:h-6 sm:w-6 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm sm:text-base">Er zijn geen producten bekend die behoren bij de
                                    geselecteerde productcategorie.</span>
                            </div>
                        @else
                            <!-- Default no products message -->
                            <div class="text-center py-8 sm:py-12">
                                <svg class="mx-auto h-10 w-10 sm:h-12 sm:w-12 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4.5a2 2 0 01-2-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 01-2 2H0" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Geen producten
                                    gevonden</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Er zijn momenteel geen producten in voorraad.
                                </p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
