<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
            {{ __('Voedselpakket Overzicht') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Titel -->
            <h1 class="text-green-700 dark:text-green-400 text-2xl font-semibold mb-4 underline">Overzicht Voedselpakketten</h1>

            <!-- Gezin Details -->
            <div class="bg-white shadow-md rounded border overflow-hidden w-full max-w-2xl">
                <table class="min-w-full text-sm text-left border-collapse">
                    <tr class="border">
                        <th class="px-4 py-2 border w-1/3">Naam:</th>
                        <td class="px-4 py-2 border">~~ PENDING</td>
                    </tr>
                    <tr class="border">
                        <th class="px-4 py-2 border">Omschrijving:</th>
                        <td class="px-4 py-2 border">~~ PENDING</td>
                    </tr>
                    <tr class="border">
                        <th class="px-4 py-2 border">Totaal aantal Personen:</th>
                        <td class="px-4 py-2 border">~~ PENDING</td>
                    </tr>
                </table>
            </div>

            <!-- Voedselpakketten Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Pakketnummer</th>
                            <th class="px-4 py-2 border">Datum samenstelling</th>
                            <th class="px-4 py-2 border">Datum uitgifte</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Aantal producten</th>
                            <th class="px-4 py-2 border">Wijzig Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 3; $i++)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">~~ PENDING</td>
                                <td class="px-4 py-2 border">~~ PENDING</td>
                                <td class="px-4 py-2 border">~~ PENDING</td>
                                <td class="px-4 py-2 border">~~ PENDING</td>
                                <td class="px-4 py-2 border">~~ PENDING</td>
                                <td class="px-4 py-2 border text-center">
                                    <a href="#" class="text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4 inline-block" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M15.232 5.232l3.536 3.536M4 20h4.586a1 1 0 0 0 .707-.293l10-10a1 1 0 0 0 0-1.414l-3.586-3.586a1 1 0 0 0-1.414 0l-10 10A1 1 0 0 0 4 20z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Navigatieknoppen -->
            <div class="flex justify-end gap-2">
                <a href="{{ route('voedselpakketten.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">terug</a>
                <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">home</a>
            </div>

        </div>
    </div>
</x-app-layout>
