<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Klant Bewerken') }} - {{ $gezin->naam }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('klanten.show', $gezin) }}" 
                   class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md shadow-sm">
                    Annuleren
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- General Error Message -->
            @if($errors->has('general'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ $errors->first('general') }}
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('klanten.update', $gezin) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gezin Informatie -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Gezin Informatie</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="gezin_naam" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gezinnaam</label>
                                    <input type="text" name="gezin_naam" id="gezin_naam" 
                                           value="{{ old('gezin_naam', $gezin->naam) }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                           required>
                                    @error('gezin_naam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label for="aantal_volwassenen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Volwassenen</label>
                                        <input type="number" name="aantal_volwassenen" id="aantal_volwassenen" 
                                               value="{{ old('aantal_volwassenen', $gezin->aantal_volwassenen) }}" min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                               required>
                                        @error('aantal_volwassenen')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="aantal_kinderen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kinderen</label>
                                        <input type="number" name="aantal_kinderen" id="aantal_kinderen" 
                                               value="{{ old('aantal_kinderen', $gezin->aantal_kinderen) }}" min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                               required>
                                        @error('aantal_kinderen')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="aantal_babys" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Baby's</label>
                                        <input type="number" name="aantal_babys" id="aantal_babys" 
                                               value="{{ old('aantal_babys', $gezin->aantal_babys) }}" min="0"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                               required>
                                        @error('aantal_babys')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vertegenwoordiger -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Vertegenwoordiger</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="vertegenwoordiger_voornaam" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam</label>
                                    <input type="text" name="vertegenwoordiger_voornaam" id="vertegenwoordiger_voornaam" 
                                           value="{{ old('vertegenwoordiger_voornaam', $vertegenwoordiger ? $vertegenwoordiger->voornaam : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                           required>
                                    @error('vertegenwoordiger_voornaam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="vertegenwoordiger_tussenvoegsel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                                    <input type="text" name="vertegenwoordiger_tussenvoegsel" id="vertegenwoordiger_tussenvoegsel" 
                                           value="{{ old('vertegenwoordiger_tussenvoegsel', $vertegenwoordiger ? $vertegenwoordiger->tussenvoegsel : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('vertegenwoordiger_tussenvoegsel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="vertegenwoordiger_achternaam" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam</label>
                                    <input type="text" name="vertegenwoordiger_achternaam" id="vertegenwoordiger_achternaam" 
                                           value="{{ old('vertegenwoordiger_achternaam', $vertegenwoordiger ? $vertegenwoordiger->achternaam : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                           required>
                                    @error('vertegenwoordiger_achternaam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Informatie -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg md:col-span-2">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Contact Informatie</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mailadres</label>
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $contact ? $contact->email : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="mobiel" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Mobiel</label>
                                    <input type="text" name="mobiel" id="mobiel" 
                                           value="{{ old('mobiel', $contact ? $contact->mobiel : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('mobiel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="straat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Straat</label>
                                    <input type="text" name="straat" id="straat" 
                                           value="{{ old('straat', $contact ? $contact->straat : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('straat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label for="huisnummer" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Huisnummer</label>
                                        <input type="text" name="huisnummer" id="huisnummer" 
                                               value="{{ old('huisnummer', $contact ? $contact->huisnummer : '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('huisnummer')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label for="toevoeging" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Toevoeging</label>
                                        <input type="text" name="toevoeging" id="toevoeging" 
                                               value="{{ old('toevoeging', $contact ? $contact->toevoeging : '') }}"
                                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @error('toevoeging')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label for="postcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postcode</label>
                                    <input type="text" name="postcode" id="postcode" 
                                           value="{{ old('postcode', $contact ? $contact->postcode : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('postcode') border-red-500 @enderror"
                                           placeholder="Bijv. 5271TH">
                                    @error('postcode')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Alleen postcodes uit de regio Maaskantje (5271XX) zijn toegestaan</p>
                                </div>

                                <div>
                                    <label for="woonplaats" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Woonplaats</label>
                                    <input type="text" name="woonplaats" id="woonplaats" 
                                           value="{{ old('woonplaats', $contact ? $contact->woonplaats : '') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('woonplaats')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('klanten.show', $gezin) }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium rounded-md shadow-sm">
                        Annuleren
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Wijzig Klant Details
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
