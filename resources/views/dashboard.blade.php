<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl leading-tight text-gray-900 dark:text-gray-100">
                {{ __('Dashboard') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            @if (session('success'))
                <div class="bg-green-500 text-white p-4 rounded mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-6">
                        {{ __("You're logged in!") }}
                    </div>
                    
                    <!-- Navigation Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <a href="{{ route('klanten.index') }}" 
                           class="block p-6 bg-blue-50 dark:bg-blue-900 border border-blue-200 dark:border-blue-700 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-800 transition-colors duration-200">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Overzicht Klanten</h3>
                                    <p class="text-sm text-blue-600 dark:text-blue-300">Bekijk alle geregistreerde gezinnen</p>
                                </div>
                            </div>
                        </a>
                        
                        <!-- Additional navigation items can be added here -->
                        <div class="block p-6 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg opacity-50">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-500">Voorraadbeheer</h3>
                                    <p class="text-sm text-gray-400">Binnenkort beschikbaar</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="block p-6 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg opacity-50">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-500">Rapporten</h3>
                                    <p class="text-sm text-gray-400">Binnenkort beschikbaar</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dashboard.system-controls :isMaintenanceMode="$isMaintenanceMode" />

</x-app-layout>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Verify Chart.js loaded
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chart === 'undefined') {
            console.error('Chart.js failed to load!');
            alert('Error: Chart.js could not be loaded. Some dashboard features may not work.');
        } else {
            console.log('Chart.js loaded successfully');
        }

        // Collapsible functionality
        const collapsibleHeaders = document.querySelectorAll('.collapsible-header');

        // Save collapsed state to localStorage
        function saveCollapsedState(id, isCollapsed) {
            localStorage.setItem('collapsed-' + id, isCollapsed);
        }

        // Get collapsed state from localStorage with default to collapsed
        function getCollapsedState(id) {
            const saved = localStorage.getItem('collapsed-' + id);
            // If no saved state, default to collapsed (true)
            return saved === null ? true : saved === 'true';
        }

        collapsibleHeaders.forEach(header => {
            const targetId = header.dataset.target;
            const content = document.getElementById(targetId);
            const arrow = header.querySelector('.collapsible-arrow');

            // Set initial state from localStorage or default to collapsed
            const isCollapsed = getCollapsedState(targetId);
            if (isCollapsed) {
                content.style.maxHeight = '0px';
                content.style.overflow = 'hidden';
                arrow.classList.add('rotate-180');
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
            }

            header.addEventListener('click', () => {
                const isCollapsed = content.style.maxHeight === '0px' || content.style
                    .maxHeight === '';

                if (isCollapsed) {
                    content.style.maxHeight = content.scrollHeight + 'px';
                    arrow.classList.remove('rotate-180');
                    saveCollapsedState(targetId, false);
                } else {
                    content.style.maxHeight = '0px';
                    arrow.classList.add('rotate-180');
                    saveCollapsedState(targetId, true);
                }
            });
        });
    });
</script>
<style>
    .collapsible-content {
        max-height: 0px;
        /* Default to collapsed */
        overflow: hidden;
        transition: max-height 0.3s ease-in-out;
    }

    .rotate-180 {
        transform: rotate(180deg);
    }

    .collapsible-header {
        transition: background-color 0.2s ease;
    }

    .collapsible-header:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }
</style>
