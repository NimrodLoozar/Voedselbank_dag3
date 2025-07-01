<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Overzicht Productvoorraden') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            <!-- Category Filter Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                        Filter op Productcategorie
                    </h3>

                    <form action="{{ route('inventory.category') }}" method="POST"
                        class="flex flex-wrap items-end gap-4">
                        @csrf

                        <div class="flex-1 min-w-64">
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

                        <div class="flex gap-2">
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Toon Voorraad
                            </button>

                            <a href="{{ route('inventory.overview') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Toon Alle Producten
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Inventory Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Voorraadproducten
                            @if (isset($categorie))
                                - {{ $categorie->naam }}
                            @endif
                        </h3>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            Totaal: {{ $producten->count() }} {{ $producten->count() === 1 ? 'product' : 'producten' }}
                        </div>
                    </div>

                    @if ($producten->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Product
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Categorie
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Barcode
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Houdbaarheidsdatum
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Magazijnlocaties
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Allergie
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
                                                {{ $product->barcode }}
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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'OpVoorraad' => 'bg-green-100 text-green-800',
                                                        'NietOpVoorraad' => 'bg-red-100 text-red-800',
                                                        'NietLeverbaar' => 'bg-gray-100 text-gray-800',
                                                        'OverHoudbaarheidsDatum' => 'bg-yellow-100 text-yellow-800',
                                                    ];
                                                @endphp
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $product->status }}
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
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                @if ($product->soort_allergie)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-100 text-orange-800">
                                                        {{ $product->soort_allergie }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Geen</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4.5a2 2 0 01-2-2V8a2 2 0 00-2-2H9a2 2 0 00-2 2v3a2 2 0 01-2 2H0" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">Geen producten
                                gevonden</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                @if (isset($selectedCategory) && $selectedCategory)
                                    Er zijn geen producten bekend die behoren bij de geselecteerde productcategorie.
                                @else
                                    Er zijn momenteel geen producten in voorraad.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
