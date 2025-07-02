@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                Magazijn Overzicht
            </h1>
            <a href="{{ route('magazijnen.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Nieuw Magazijn Item
            </a>
        </div>

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

        {{-- Statistieken kaarten --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6" id="statistics-cards">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Totaal Magazijnen
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-gray-100" id="totaal-magazijnen">
                                    Laden...
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Totaal Items
                                </dt>
                                <dd class="text-lg font-medium text-gray-900 dark:text-gray-100" id="totaal-items">
                                    Laden...
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    In Voorraad
                                </dt>
                                <dd class="text-lg font-medium text-green-600" id="nog-in-voorraad">
                                    Laden...
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Uitgeleverd
                                </dt>
                                <dd class="text-lg font-medium text-red-600" id="uitgeleverd">
                                    Laden...
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Verlopende producten waarschuwing --}}
        <div id="expiring-products-alert"
            class="hidden bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm">
                        <strong>Let op!</strong> Er zijn <span id="expiring-count">0</span> producten die binnenkort
                        verlopen.
                        <button onclick="showExpiringProducts()" class="underline hover:no-underline ml-1">
                            Bekijk details
                        </button>
                    </p>
                </div>
            </div>
        </div>

        {{-- Magazijn overzicht tabel --}}
        <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Magazijn Items
                </h3>

                @if ($magazijnen->count() > 0)
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
                                        Aantal
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Verpakking
                                    </th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Ontvangst
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
                                @foreach ($magazijnen as $magazijn)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $magazijn->product_naam ?? 'Geen product gekoppeld' }}
                                            </div>
                                            @if (isset($magazijn->categorie_naam))
                                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $magazijn->categorie_naam }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $magazijn->aantal }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $magazijn->verpakkings_eenheid }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                                {{ $magazijn->ontvangstdatum->format('d-m-Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $magazijn->dagen_in_voorraad }} dagen geleden
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($magazijn->uitleveringsdatum)
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                    Uitgeleverd
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Op voorraad
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('magazijnen.show', $magazijn) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">
                                                Bekijken
                                            </a>
                                            <a href="{{ route('magazijnen.edit', $magazijn) }}"
                                                class="text-green-600 hover:text-green-900 mr-3">
                                                Bewerken
                                            </a>
                                            <form method="POST" action="{{ route('magazijnen.destroy', $magazijn) }}"
                                                class="inline-block"
                                                onsubmit="return confirm('Weet je zeker dat je dit magazijn item wilt verwijderen?')">
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
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                            Geen magazijn items
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Begin door je eerste magazijn item toe te voegen.
                        </p>
                        <div class="mt-6">
                            <a href="{{ route('magazijnen.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                                Nieuw item toevoegen
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- JavaScript voor statistieken en verlopende producten --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Laad statistieken
            loadStatistics();

            // Check voor verlopende producten
            checkExpiringProducts();
        });

        function loadStatistics() {
            fetch('{{ route('magazijnen.statistics') }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data) {
                        const stats = data.data;
                        document.getElementById('totaal-magazijnen').textContent = stats.totaal_magazijnen || 0;
                        document.getElementById('totaal-items').textContent = stats.totaal_items || 0;
                        document.getElementById('nog-in-voorraad').textContent = stats.nog_in_voorraad || 0;
                        document.getElementById('uitgeleverd').textContent = stats.uitgeleverd || 0;
                    }
                })
                .catch(error => {
                    console.error('Error loading statistics:', error);
                    document.getElementById('totaal-magazijnen').textContent = 'Error';
                    document.getElementById('totaal-items').textContent = 'Error';
                    document.getElementById('nog-in-voorraad').textContent = 'Error';
                    document.getElementById('uitgeleverd').textContent = 'Error';
                });
        }

        function checkExpiringProducts() {
            fetch('{{ route('api.expiring-products') }}?dagen=7')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.count > 0) {
                        document.getElementById('expiring-count').textContent = data.count;
                        document.getElementById('expiring-products-alert').classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error checking expiring products:', error);
                });
        }

        function showExpiringProducts() {
            // Implementeer modal of redirect naar overzicht van verlopende producten
            window.location.href = '{{ route('inventory.overview') }}?expiring=true';
        }
    </script>
@endsection
