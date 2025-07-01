<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Wijzig Product Details') }} - {{ $product->naam }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    De productgegevens kunnen niet worden gewijzigd
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    De productgegevens kunnen niet worden gewijzigd
                </div>
            @endif

            <!-- Edit Product Form -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-6">
                        Wijzig Product Details {{ $product->naam }}
                    </h3>

                    <form action="{{ route('inventory.update', $product) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @if ($product->magazijnen->count() > 0)
                            @php
                                $magazijn = $product->magazijnen->first(); // Use first warehouse for simplicity
                            @endphp

                            <input type="hidden" name="magazijn_updates[0][magazijn_id]" value="{{ $magazijn->id }}">

                            <div class="space-y-4">
                                <!-- Productnaam (read-only) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Productnaam</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">{{ $product->naam }}</span>
                                </div>

                                <!-- Houdbaarheidsdatum (read-only) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Houdbaarheidsdatum</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-gray-100">{{ $product->houdbaarheidsdatum->format('d-m-Y') }}</span>
                                </div>

                                <!-- Barcode (read-only) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Barcode</span>
                                    <span
                                        class="text-sm text-gray-900 dark:text-gray-100">{{ $product->barcode }}</span>
                                </div>

                                <!-- Magazijn Locatie (editable dropdown) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Magazijn
                                        Locatie</span>
                                    <div class="w-48">
                                        <select name="magazijn_updates[0][locatie]"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
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

                                <!-- Ontvangstdatum (read-only) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Ontvangstdatum</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $magazijn->ontvangstdatum ? $magazijn->ontvangstdatum->format('d-m-Y') : 'Onbekend' }}
                                    </span>
                                </div>

                                <!-- Aantal uitgeleverde producten (editable) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aantal
                                        uitgeleverde producten:</span>
                                    <div class="w-48">
                                        <input type="number" name="magazijn_updates[0][aantal_uitgeleverd]"
                                            value="{{ old('magazijn_updates.0.aantal_uitgeleverd', 0) }}"
                                            min="0"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                            required>
                                        @if (session('error') || $errors->any())
                                            <p class="mt-1 text-sm text-red-600">
                                                Er worden meer producten uitgeleverd dan er in voorraad zijn
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Uitleveringsdatum (editable date picker) -->
                                <div
                                    class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-sm font-medium text-gray-700 dark:text-gray-300">Uitleveringsdatum</span>
                                    <div class="w-48">
                                        <input type="date" name="uitleveringsdatum"
                                            value="{{ $magazijn->uitleveringsdatum ? $magazijn->uitleveringsdatum->format('Y-m-d') : now()->format('Y-m-d') }}"
                                            class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600">
                                    </div>
                                </div>

                                <!-- Aantal op voorraad (read-only) -->
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aantal op
                                        voorraad</span>
                                    <span class="text-sm text-gray-900 dark:text-gray-100">
                                        {{ $magazijn->aantal }} {{ $magazijn->verpakkings_eenheid ?? 'eenheden' }}
                                    </span>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-8 flex justify-between">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                                    Wijzig Product Details
                                </button>
                                <div class="flex gap-2">
                                    <a href="{{ route('inventory.details', $product) }}"
                                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        terug
                                    </a>
                                    <a href="{{ route('inventory.overview') }}"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        home
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">Dit product is niet in voorraad in enig
                                    magazijn.</p>
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
