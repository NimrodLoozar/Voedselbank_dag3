<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Wijzig Klant Details') }} - {{ $vertegenwoordiger->voornaam }} {{ $vertegenwoordiger->tussenvoegsel }} {{ $vertegenwoordiger->achternaam }}
        </h2>
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

            <!-- Success Message with Auto-redirect -->
            @if(session('success') && session('redirect_to_show'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('klanten.update', $gezin) }}">
                @csrf
                @method('PUT')

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                
                        <!-- Contact Update Error Message -->
                        @if($errors->has('postcode') && str_contains($errors->first('postcode'), 'Maaskantje'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    De Contactgegevens kunnen niet worden gewijzigd
                                </div>
                            </div>
                        @endif
                
                        <div class="space-y-4 max-w-4xl">
                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="vertegenwoordiger_voornaam" class="text-sm font-medium text-gray-700 dark:text-gray-300">Voornaam</label>
                                <div class="col-span-2">
                                    <input type="text" name="vertegenwoordiger_voornaam" id="vertegenwoordiger_voornaam" 
                                           value="{{ old('vertegenwoordiger_voornaam', $vertegenwoordiger ? $vertegenwoordiger->voornaam : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                    @error('vertegenwoordiger_voornaam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="vertegenwoordiger_tussenvoegsel" class="text-sm font-medium text-gray-700 dark:text-gray-300">Tussenvoegsel</label>
                                <div class="col-span-2">
                                    <input type="text" name="vertegenwoordiger_tussenvoegsel" id="vertegenwoordiger_tussenvoegsel" 
                                           value="{{ old('vertegenwoordiger_tussenvoegsel', $vertegenwoordiger ? $vertegenwoordiger->tussenvoegsel : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('vertegenwoordiger_tussenvoegsel')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="vertegenwoordiger_achternaam" class="text-sm font-medium text-gray-700 dark:text-gray-300">Achternaam</label>
                                <div class="col-span-2">
                                    <input type="text" name="vertegenwoordiger_achternaam" id="vertegenwoordiger_achternaam" 
                                           value="{{ old('vertegenwoordiger_achternaam', $vertegenwoordiger ? $vertegenwoordiger->achternaam : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                    @error('vertegenwoordiger_achternaam')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="geboortedatum" class="text-sm font-medium text-gray-700 dark:text-gray-300">Geboortedatum</label>
                                <div class="col-span-2">
                                    <input type="date" name="geboortedatum" id="geboortedatum" 
                                           value="{{ old('geboortedatum', $vertegenwoordiger && $vertegenwoordiger->geboortedatum ? $vertegenwoordiger->geboortedatum->format('Y-m-d') : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="dd-mm-jjjj">
                                    @error('geboortedatum')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="type_persoon" class="text-sm font-medium text-gray-700 dark:text-gray-300">Type Persoon</label>
                                <div class="col-span-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-600 text-sm text-gray-900 dark:text-gray-100">
                                    {{ $vertegenwoordiger ? $vertegenwoordiger->type_persoon : 'Onbekend' }}
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Vertegenwoordiger</label>
                                <div class="col-span-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-600 text-sm text-gray-900 dark:text-gray-100">
                                    Ja
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="straat" class="text-sm font-medium text-gray-700 dark:text-gray-300">Straatnaam</label>
                                <div class="col-span-2">
                                    <input type="text" name="straat" id="straat" 
                                           value="{{ old('straat', $contact ? $contact->straat : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('straat')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="huisnummer" class="text-sm font-medium text-gray-700 dark:text-gray-300">Huisnummer</label>
                                <div class="col-span-2">
                                    <input type="number" name="huisnummer" id="huisnummer" 
                                           value="{{ old('huisnummer', $contact ? $contact->huisnummer : '') }}"
                                           min="1" max="9999"
                                           placeholder="Bijv. 10"
                                           title="Voer een geldig huisnummer in (1-9999)"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('huisnummer') border-red-500 @enderror">
                                    @error('huisnummer')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        Voer een positief huisnummer in (1-9999)
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="toevoeging" class="text-sm font-medium text-gray-700 dark:text-gray-300">Toevoeging</label>
                                <div class="col-span-2">
                                    <input type="text" name="toevoeging" id="toevoeging" 
                                           value="{{ old('toevoeging', $contact ? $contact->toevoeging : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('toevoeging')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="postcode" class="text-sm font-medium text-gray-700 dark:text-gray-300">Postcode</label>
                                <div class="col-span-2">
                                    <input type="text" name="postcode" id="postcode" 
                                           value="{{ old('postcode', $contact ? $contact->postcode : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('postcode') border-red-500 @enderror"
                                           placeholder="Bijv. 5271TH">
                                    @error('postcode')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="woonplaats" class="text-sm font-medium text-gray-700 dark:text-gray-300">Woonplaats</label>
                                <div class="col-span-2">
                                    <input type="text" name="woonplaats" id="woonplaats" 
                                           value="{{ old('woonplaats', $contact ? $contact->woonplaats : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('woonplaats')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="email" class="text-sm font-medium text-gray-700 dark:text-gray-300">E-mail</label>
                                <div class="col-span-2">
                                    <input type="email" name="email" id="email" 
                                           value="{{ old('email', $contact ? $contact->email : '') }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-4 items-center">
                                <label for="mobiel" class="text-sm font-medium text-gray-700 dark:text-gray-300">Mobiel</label>
                                <div class="col-span-2">
                                    <input type="tel" name="mobiel" id="mobiel" 
                                           value="{{ old('mobiel', $contact ? $contact->mobiel : '') }}"
                                           pattern="^(06[0-9]{8}|\+31\s6[0-9]{8}|0031\s6[0-9]{8})$"
                                           placeholder="Bijv. 06xxxxxxxx of +31 6xxxxxxxx"
                                           title="Voer een geldig Nederlands mobiel nummer in (bijv. 06xxxxxxxx of +31 6xxxxxxxx)"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-sm text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('mobiel') border-red-500 @enderror">
                                    @error('mobiel')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-1 text-xs text-gray-500">
                                        Voer een Nederlands mobiel nummer in (bijv. 06xxxxxxxx of +31 6xxxxxxxx)
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="mt-8 flex justify-between">
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Wijzig Klant Details
                            </button>
                            <div class="flex space-x-3">
                                <a href="{{ route('klanten.show', $gezin) }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                                    terug
                                </a>
                                <a href="{{ url('/') }}" 
                                   class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm">
                                    home
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for mobile number and house number validation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileInput = document.getElementById('mobiel');
            const houseNumberInput = document.getElementById('huisnummer');
            
            // Mobile number validation
            if (mobileInput) {
                // Real-time validation feedback
                mobileInput.addEventListener('input', function() {
                    const value = this.value.trim();
                    if (value === '') {
                        clearMobileValidationFeedback();
                        return;
                    }
                    
                    if (isValidDutchMobile(value)) {
                        showMobileValidFeedback();
                    } else {
                        showMobileInvalidFeedback();
                    }
                });

                // Format mobile number as user types
                mobileInput.addEventListener('input', function() {
                    let value = this.value;
                    
                    // If user types +31 followed by 6, add a space
                    if (value === '+316') {
                        this.value = '+31 6';
                    }
                    // If user types 0031 followed by 6, add a space  
                    else if (value === '00316') {
                        this.value = '0031 6';
                    }
                });
            }

            // House number validation
            if (houseNumberInput) {
                houseNumberInput.addEventListener('input', function() {
                    const value = parseInt(this.value);
                    
                    if (this.value === '') {
                        clearHouseNumberValidationFeedback();
                        return;
                    }

                    if (isNaN(value) || value < 1 || value > 9999) {
                        showHouseNumberInvalidFeedback();
                    } else {
                        showHouseNumberValidFeedback();
                    }
                });

                // Prevent negative numbers from being entered
                houseNumberInput.addEventListener('keydown', function(e) {
                    // Allow: backspace, delete, tab, escape, enter
                    if ([8, 9, 27, 13, 46].indexOf(e.keyCode) !== -1 ||
                        // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                        (e.keyCode === 65 && e.ctrlKey === true) ||
                        (e.keyCode === 67 && e.ctrlKey === true) ||
                        (e.keyCode === 86 && e.ctrlKey === true) ||
                        (e.keyCode === 88 && e.ctrlKey === true) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 39)) {
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });

                // Prevent pasting negative numbers
                houseNumberInput.addEventListener('paste', function(e) {
                    setTimeout(() => {
                        const value = parseInt(this.value);
                        if (isNaN(value) || value < 1) {
                            this.value = '';
                            showHouseNumberInvalidFeedback();
                        }
                    }, 0);
                });
            }

            function isValidDutchMobile(mobile) {
                // Trim whitespace
                mobile = mobile.trim();
                const patterns = [
                    /^06[0-9]{8}$/,        // 06XXXXXXXX
                    /^\+31\s6[0-9]{8}$/,   // +31 6XXXXXXXX (with space)
                    /^0031\s6[0-9]{8}$/    // 0031 6XXXXXXXX (with space)
                ];
                
                return patterns.some(pattern => pattern.test(mobile));
            }

            function showMobileValidFeedback() {
                const input = document.getElementById('mobiel');
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            }

            function showMobileInvalidFeedback() {
                const input = document.getElementById('mobiel');
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }

            function clearMobileValidationFeedback() {
                const input = document.getElementById('mobiel');
                input.classList.remove('border-red-500', 'border-green-500');
            }

            function showHouseNumberValidFeedback() {
                const input = document.getElementById('huisnummer');
                input.classList.remove('border-red-500');
                input.classList.add('border-green-500');
            }

            function showHouseNumberInvalidFeedback() {
                const input = document.getElementById('huisnummer');
                input.classList.remove('border-green-500');
                input.classList.add('border-red-500');
            }

            function clearHouseNumberValidationFeedback() {
                const input = document.getElementById('huisnummer');
                input.classList.remove('border-red-500', 'border-green-500');
            }

            // Auto-redirect functionality for success message
            @if(session('success') && session('redirect_to_show'))
                // Start redirect timer immediately
                setTimeout(() => {
                    window.location.href = '{{ route("klanten.show", $gezin) }}';
                }, 3000); // 3 seconds
            @endif
        });
    </script>
</x-app-layout>
