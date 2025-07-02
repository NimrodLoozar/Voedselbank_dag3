<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Voedselbank Maaskantje</title>

    <!-- Script to prevent flash of incorrect theme -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia(
                '(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- favicon -->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Protest+Guerrilla&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <nav class="fixed z-50 right-10 top-10">
        <x-theme-toggle />
    </nav>
    <div class="relative min-h-screen bg-cover bg-center"
        style="background: #ffee00; background: linear-gradient(212deg, rgba(255, 238, 0, 1) 0%, rgba(237, 168, 83, 1) 100%);">
        <div class="absolute inset-0 bg-black opacity-50 pointer-events-none"></div>
        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="mb-6">
                <a href="/" class="flex items-center justify-center">
                    <svg class="w-16 h-16 text-white" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95">
                {{ $slot }}
            </div>
        </div>
    </div>
    <!-- Emergency direct toggle for testing -->
    {{-- <div class="fixed bottom-5 right-5 z-50">
        <button
            onclick="document.documentElement.classList.toggle('dark'); localStorage.setItem('color-theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');"
            class="bg-white dark:bg-gray-800 p-2 rounded-full shadow-lg text-gray-500 dark:text-gray-400">
            Toggle Dark Mode
        </button>
    </div> --}}
</body>

</html>
