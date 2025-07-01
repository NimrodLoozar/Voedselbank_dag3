<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
            {{ __('Wijzig Voedselpakket Status') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-xl mx-auto space-y-6">
            <!-- Titel -->
            <h1 class="text-2xl font-semibold text-green-700 underline">Wijzig voedselpakket status</h1>

            <!-- Formulier -->
            <form method="POST" action="{{ route('voedselpakket.update', $pakket->id) }}">
                @csrf
                @method('PUT')

                <div>
                    <select name="status" class="w-full border rounded px-3 py-2">
                        <option value="Niet Uitgereikt" {{ $pakket->status === 'Niet Uitgereikt' ? 'selected' : '' }}>Niet Uitgereikt</option>
                        <option value="Uitgereikt" {{ $pakket->status === 'Uitgereikt' ? 'selected' : '' }}>Uitgereikt</option>
                        <!-- Voeg extra statussen toe indien nodig -->
                    </select>
                </div>

                <div class="mt-4 flex gap-2">
                    <button type="submit" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Wijzig status voedselpakket
                    </button>

                    <a href="{{ url()->previous() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        terug
                    </a>

                    <a href="{{ route('dashboard') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        home
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
