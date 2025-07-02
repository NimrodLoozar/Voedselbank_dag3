<x-app-layout>
    {{-- Header sectie met de titel van de pagina --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Wijzig Product Details') }} - {{ $product->naam }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Foutmeldingen weergeven als er iets mis gaat --}}
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    De productgegevens kunnen niet worden gewijzigd
                </div>
            @endif

            {{-- Validatie fouten tonen als er iets verkeerd is ingevuld --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    De productgegevens kunnen niet worden gewijzigd
                </div>
            @endif

            {{-- Hoofdformulier voor het bewerken van productgegevens --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    {{-- Titel van het formulier --}}
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        Wijzig Product Details {{ $product->naam }}
                    </h3>

                    {{-- Formulier dat naar de update route stuurt met PUT method --}}
                    <form action="{{ route('inventory.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Controleren of er magazijnen gekoppeld zijn aan dit product --}}
                        @if ($product->magazijnen->count() > 0)
                            @php
                                // We pakken het eerste magazijn voor de eenvoud
                                $magazijn = $product->magazijnen->first();
                            @endphp

                            {{-- Verborgen veld om het magazijn ID mee te sturen --}}
                            <input type="hidden" name="magazijn_updates[0][magazijn_id]" value="{{ $magazijn->id }}">

                            <div class="space-y-4">
                                {{-- Productnaam - alleen lezen, niet aanpasbaar --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Productnaam</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">{{ $product->naam }}</span>
                                </div>

                                {{-- Houdbaarheidsdatum - alleen lezen --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Houdbaarheidsdatum</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-gray-100">{{ $product->houdbaarheidsdatum->format('d-m-Y') }}</span>
                                </div>

                                {{-- Barcode - alleen lezen --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Barcode</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-gray-100">{{ $product->barcode }}</span>
                                </div>

                                {{-- Dropdown voor magazijn locatie - dit kan aangepast worden --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Magazijn
                                        Locatie</span>
                                    <div class="w-48">
                                        <select name="magazijn_updates[0][locatie]"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                            {{-- Opties voor verschillende locaties met huidige waarde geselecteerd --}}
                                            <option value="Berlicum"
                                                {{ ($magazijn->pivot->locatie ?? '') == 'Berlicum' ? 'selected' : '' }}>
                                                Berlicum</option>
                                            <option value="Oss"
                                                {{ ($magazijn->pivot->locatie ?? '') == 'Oss' ? 'selected' : '' }}>Oss
                                            </option>
                                            <option value="Den Bosch"
                                                {{ ($magazijn->pivot->locatie ?? '') == 'Den Bosch' ? 'selected' : '' }}>
                                                Den Bosch</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Ontvangstdatum - alleen lezen --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Ontvangstdatum</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{-- Als er geen datum is, toon 'Onbekend' --}}
                                        {{ $magazijn->ontvangstdatum ? $magazijn->ontvangstdatum->format('d-m-Y') : 'Onbekend' }}
                                    </span>
                                </div>

                                {{-- Aantal uitgeleverde producten - dit kan aangepast worden --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aantal
                                        uitgeleverde producten:</span>
                                    <div class="w-48">
                                        {{-- Nummer input met minimum waarde 0 --}}
                                        <input type="number" name="magazijn_updates[0][aantal_uitgeleverd]"
                                            value="{{ old('magazijn_updates.0.aantal_uitgeleverd', 0) }}"
                                            min="0"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                            required>
                                        {{-- Foutmelding als er meer wordt uitgeleverd dan voorradig --}}
                                        @if (session('error') || $errors->any())
                                            <p class="mt-1 text-sm text-red-600">
                                                Er worden meer producten uitgeleverd dan er in voorraad zijn
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                {{-- Datum picker voor uitleveringsdatum --}}
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Uitleveringsdatum</span>
                                    <div class="w-48">
                                        {{-- Datum input met huidige waarde of vandaag als standaard --}}
                                        <input type="date" name="uitleveringsdatum"
                                            value="{{ $magazijn->uitleveringsdatum ? $magazijn->uitleveringsdatum->format('Y-m-d') : now()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    </div>
                                </div>

                                {{-- Huidige voorraad - alleen lezen --}}
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aantal op
                                        voorraad</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{-- Voorraad met de verpakkingseenheid of 'eenheden' als fallback --}}
                                        {{ $magazijn->aantal }} {{ $magazijn->verpakkings_eenheid ?? 'eenheden' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Knoppen voor acties onderaan het formulier --}}
                            <div class="mt-8 flex justify-between">
                                {{-- Submit knop om wijzigingen op te slaan --}}
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                                    Wijzig Product Details
                                </button>
                                {{-- Navigatie knoppen --}}
                                <div class="flex gap-2">
                                    {{-- Terug naar detail pagina --}}
                                    <a href="{{ route('inventory.details', $product) }}"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        terug
                                    </a>
                                    {{-- Naar overzicht pagina --}}
                                    <a href="{{ route('inventory.overview') }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        home
                                    </a>
                                </div>
                            </div>
                        @else
                            {{-- Melding als product niet op voorraad is --}}
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Dit product is niet in voorraad in enig
                                    magazijn.</p>
                                {{-- Knop om terug te gaan naar details --}}
                                <a href="{{ route('inventory.details', $product) }}"
                                    class="mt-4 bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded inline-block">
                                    Terug naar Details
                                </a>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
