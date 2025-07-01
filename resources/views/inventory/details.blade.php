<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
            {{ __('Product Details') }} - {{ $product->naam }}
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

                <!-- Auto-redirect after 3 seconds on success -->
                <script>
                    setTimeout(function() {
                        window.location.href = "{{ route('inventory.details', $product) }}";
                    }, 3000);
                </script>
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

            <!-- Product Information -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Product Details {{ $product->naam }}
                        </h3>
                        <div class="flex gap-2">
                            <a href="{{ route('inventory.edit', $product) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Wijzig
                            </a>
                            <a href="{{ route('inventory.overview') }}"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                terug
                            </a>
                            <a href="{{ route('inventory.overview') }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                home
                            </a>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Productnaam</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $product->naam }}</span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Houdbaarheidsdatum</span>
                            <span
                                class="text-sm text-gray-900 dark:text-gray-100">{{ $product->houdbaarheidsdatum->format('d-m-Y') }}</span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Barcode</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">{{ $product->barcode }}</span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Magazijn locatie</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                @if ($product->magazijnen->count() > 0)
                                    {{ $product->magazijnen->first()->pivot->locatie ?? 'Onbekend' }}
                                @else
                                    Geen locatie
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ontvangstdatum</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                @if ($product->magazijnen->count() > 0)
                                    {{ $product->magazijnen->first()->ontvangstdatum ? $product->magazijnen->first()->ontvangstdatum->format('d-m-Y') : 'Onbekend' }}
                                @else
                                    Onbekend
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between py-3 border-b border-gray-200 dark:border-gray-700">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Uitleveringsdatum</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                @if ($product->magazijnen->count() > 0)
                                    {{ $product->magazijnen->first()->uitleveringsdatum ? $product->magazijnen->first()->uitleveringsdatum->format('d-m-Y') : 'Niet uitgegeven' }}
                                @else
                                    Niet uitgegeven
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between py-3">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Aantal op voorraad</span>
                            <span class="text-sm text-gray-900 dark:text-gray-100">
                                @if ($product->magazijnen->count() > 0)
                                    {{ $product->magazijnen->sum('aantal') }}
                                    {{ $product->magazijnen->first()->verpakkings_eenheid ?? 'eenheden' }}
                                @else
                                    0 eenheden
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
