<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Klant Details') }} - {{ $vertegenwoordiger->voornaam }} {{ $vertegenwoordiger->tussenvoegsel }} {{ $vertegenwoordiger->achternaam }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Klant Details - Vertegenwoordiger -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($vertegenwoordiger)
                        <div class="space-y-0 max-w-4xl">
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Voornaam</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger->voornaam ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Tussenvoegsel</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger->tussenvoegsel ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Achternaam</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger->achternaam ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Geboortedatum</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger->geboortedatum ? $vertegenwoordiger->geboortedatum->format('d-m-Y') : '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">TypePersoon</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger->type_persoon ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Vertegenwoordiger</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    Ja
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Straatnaam</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $contact->straat ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Huisnummer</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $contact->huisnummer ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Toevoeging</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $contact->toevoeging ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Postcode</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $contact->postcode ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Woonplaats</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $contact->woonplaats ?? '~~~~~' }}
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0 border-b border-gray-200 dark:border-gray-600">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Email</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    @if($contact && $contact->email)
                                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">{{ $contact->email }}</a>
                                    @else
                                        ~~~~~
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-0">
                                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-300 border-r border-gray-200 dark:border-gray-600">Mobiel</div>
                                <div class="col-span-2 px-4 py-3 bg-white dark:bg-gray-800 text-sm text-gray-900 dark:text-gray-100">
                                    @if($contact && $contact->mobiel)
                                        <a href="tel:{{ $contact->mobiel }}" class="text-blue-600 hover:text-blue-800">{{ $contact->mobiel }}</a>
                                    @else
                                        ~~~~~~~~~~~~~~~~~~~~~~~~
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Buttons -->
                        <div class="mt-8 flex justify-between">
                            <a href="{{ route('klanten.edit', $gezin) }}" 
                               class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                                Wijzig
                            </a>
                            <div class="flex space-x-3">
                                <a href="{{ route('klanten.index') }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                                    terug
                                </a>
                                <a href="{{ url('/') }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                                    home
                                </a>
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Geen vertegenwoordiger gevonden</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <!-- Auto-redirect script after success message -->
    <script>
        // Auto-redirect after 3 seconds when success message is shown
        setTimeout(function() {
            // Reload the current page to clear the success message
            window.location.reload();
        }, 3000);
    </script>
    @endif
</x-app-layout>
