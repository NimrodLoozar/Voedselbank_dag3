<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Klant Details') }} - {{ $gezin->naam }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('klanten.edit', $gezin) }}" 
                   class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md shadow-sm">
                    Bewerken
                </a>
                <a href="{{ route('klanten.index') }}" 
                   class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md shadow-sm">
                    Terug naar Overzicht
                </a>
            </div>
        </div>
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gezin Informatie -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Gezin Informatie</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gezinnaam</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->naam }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gezinscode</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->code }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Omschrijving</dt>
                                <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->omschrijving ?: 'Geen omschrijving' }}</dd>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Volwassenen</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->aantal_volwassenen }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Kinderen</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->aantal_kinderen }}</dd>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Baby's</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $gezin->aantal_babys }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Totaal Personen</dt>
                                    <dd class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $gezin->totaal_aantal_personen }}</dd>
                                </div>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Vertegenwoordiger -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Vertegenwoordiger</h3>
                        @if($vertegenwoordiger)
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Naam</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $vertegenwoordiger->volledige_naam }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Geboortedatum</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $vertegenwoordiger->geboortedatum->format('d-m-Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">{{ $vertegenwoordiger->type_persoon }}</dd>
                                </div>
                            </dl>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">Geen vertegenwoordiger gevonden</p>
                        @endif
                    </div>
                </div>

                <!-- Contact Informatie -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Contact Informatie</h3>
                        @if($contact)
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adres</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        @if($contact->straat)
                                            {{ $contact->straat }} {{ $contact->huisnummer }}{{ $contact->toevoeging }}<br>
                                            {{ $contact->postcode }} {{ $contact->woonplaats }}
                                        @else
                                            Geen adres
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">E-mail</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        @if($contact->email)
                                            <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">{{ $contact->email }}</a>
                                        @else
                                            Geen e-mail
                                        @endif
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Mobiel</dt>
                                    <dd class="text-sm text-gray-900 dark:text-gray-100">
                                        @if($contact->mobiel)
                                            <a href="tel:{{ $contact->mobiel }}" class="text-blue-600 hover:text-blue-800">{{ $contact->mobiel }}</a>
                                        @else
                                            Geen mobiel
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">Geen contactgegevens gevonden</p>
                        @endif
                    </div>
                </div>

                <!-- Gezinsleden -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Alle Gezinsleden</h3>
                        @if($gezin->personen->count() > 0)
                            <div class="space-y-3">
                                @foreach($gezin->personen as $persoon)
                                    <div class="border-l-4 {{ $persoon->is_vertegenwoordiger ? 'border-blue-500' : 'border-gray-300' }} pl-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $persoon->volledige_naam }}
                                                    @if($persoon->is_vertegenwoordiger)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full ml-2">
                                                            Vertegenwoordiger
                                                        </span>
                                                    @endif
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                                    Geboren: {{ $persoon->geboortedatum->format('d-m-Y') }} 
                                                    ({{ $persoon->geboortedatum->age }} jaar)
                                                </p>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $persoon->type_persoon }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400 italic">Geen gezinsleden gevonden</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Eetwensen Section -->
            @if($gezin->eetwensen->count() > 0)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Eetwensen</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($gezin->eetwensen as $eetwens)
                                <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-green-100 text-green-800 rounded-full">
                                    {{ $eetwens->naam }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Voedselpakketten Section -->
            @if($gezin->voedselpakketten->count() > 0)
                <div class="mt-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recente Voedselpakketten</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Datum</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Omschrijving</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($gezin->voedselpakketten->take(5) as $pakket)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $pakket->created_at->format('d-m-Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                                {{ $pakket->omschrijving ?: 'Standaard voedselpakket' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">
                                                    Uitgegeven
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
