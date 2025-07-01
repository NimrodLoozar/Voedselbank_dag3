<footer class="bg-white dark:bg-gray-900 py-8 w-full flex justify-center">
    <div class="container mx-auto px-4 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div>
                <h3 class="text-gray-600 dark:text-gray-100 text-lg font-semibold mb-4">Voedselbank</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">Voedselbank is een professionele organisatie die zich richt op het leveren van voedselondersteuning aan mensen in nood. Wij streven ernaar om kwalitatieve voedselhulp te bieden en mensen te helpen bij het verkrijgen van toegang tot gezonde voeding.</p>
            </div>
            <div>
                <h3 class="text-gray-600 dark:text-gray-100 text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="text-gray-600 dark:text-gray-300 text-sm space-y-1">
                    <li><a href="{{ route('dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">Dashboard</a></li>
                    <li><a href="{{ route('klanten.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">Klanten</a></li>
                    <li><a href="{{ route('inventory.overview') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">Voorraad</a></li>
                    <li><a href="{{ route('voedselpakketten.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">Voedselpakketten</a></li>
                    <li><a href="{{ route('leveranciers.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">Leveranciers</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-600 dark:text-gray-100">Neem Contact op</h3>
                <p class="text-sm text-gray-600 dark:text-gray-300">123 Main Street<br>Springfield, IL 62701<br>Phone:
                    (555) 555-5555
                </p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-4 text-gray-600 dark:text-gray-100">Volg ons</h3>
                <div class="flex space-x-4">
                    <a href="https://facebook.com/voedselbank" target="_blank"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/voedselbank" target="_blank"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-400 dark:hover:text-blue-300 transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="https://linkedin.com/company/voedselbank" target="_blank"
                        class="text-gray-600 dark:text-gray-300 hover:text-blue-700 dark:hover:text-blue-500 transition duration-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="text-center mt-8 text-gray-600 dark:text-gray-100">
            <p>&copy; {{ date('Y') }} Voedselbank. Alle rechten voorbehouden.</p>
        </div>
    </div>
</footer>