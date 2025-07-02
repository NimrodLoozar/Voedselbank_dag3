<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Producten Overzicht') }}
        </h2>
    </x-slot>

    <div class="py-6 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Succes en error berichten --}}
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            {{-- Header met titel en nieuwe product knop --}}
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Producten
                </h1>
                <a href="{{ route('producten.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Nieuw Product
                </a>
            </div>

            {{-- Producten tabel --}}
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
                <div class="px-4 py-5 sm:p-6">
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
                                            Acties
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
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $product->categorie->naam ?? 'Onbekend' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                                    {{ $product->barcode }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $isExpired = $product->houdbaarheidsdatum < now();
                                                    $isExpiringSoon = $product->houdbaarheidsdatum < now()->addDays(7);
                                                @endphp
                                                <div
                                                    class="text-sm {{ $isExpired ? 'text-red-600' : ($isExpiringSoon ? 'text-yellow-600' : 'text-gray-900 dark:text-gray-100') }}">
                                                    {{ $product->houdbaarheidsdatum->format('d-m-Y') }}
                                                </div>
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
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$product->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ $product->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('producten.show', $product) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                    Bekijken
                                                </a>
                                                <a href="{{ route('producten.edit', $product) }}"
                                                    class="text-green-600 hover:text-green-900 mr-3">
                                                    Bewerken
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('producten.destroy', $product) }}"
                                                    class="inline-block"
                                                    onsubmit="return confirm('Weet je zeker dat je dit product wilt verwijderen?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Verwijderen
                                                    </button>
                                                </form>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                Geen producten
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Begin door je eerste product toe te voegen.
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('producten.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                    Nieuw product toevoegen
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
