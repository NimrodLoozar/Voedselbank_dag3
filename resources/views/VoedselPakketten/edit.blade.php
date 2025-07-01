<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
            {{ __('Wijzig Voedselpakket Status') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-xl mx-auto space-y-6">
            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        window.location.href = "{{ route('voedselpakketten.index') }}";
                    }, 3000);
                </script>
            @endif

            <!-- Titel -->
            <h1 class="text-2xl font-semibold text-green-700 dark:text-green-500 underline">Wijzig voedselpakket status</h1>

            <!-- Formulier -->
            <form method="POST" action="{{ route('voedselpakketten.update', $pakket->id) }}">
                @csrf
                @method('PATCH')

                <div>
                    <select name="status" class="w-full border rounded px-3 py-2" {{ $pakket->status === 'NietMeerIngeschreven' ? 'disabled' : '' }}>
                        <option value="NietUitgereikt" {{ $pakket->status === 'NietUitgereikt' ? 'selected' : '' }}>Niet Uitgereikt</option>
                        <option value="Uitgereikt" {{ $pakket->status === 'Uitgereikt' ? 'selected' : '' }}>Uitgereikt</option>
                        <option value="NietMeerIngeschreven" {{ $pakket->status === 'NietMeerIngeschreven' ? 'selected' : '' }}>Niet Meer Ingeschreven</option>
                    </select>
                </div>

                <br>
                 <!-- Warning Message for NietMeerIngeschreven -->
                @if($pakket->status === 'NietMeerIngeschreven')
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        Dit gezin is niet meer ingeschreven bij de voedselbank en daarom kan er geen voedselpakket worden uitgereikt
                    </div>
                @endif

                <div class="mt-4 flex gap-2">
                    <button type="submit" class="bg-gray-600 dark:bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-700 dark:hover:bg-gray-800 {{ $pakket->status === 'NietMeerIngeschreven' ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $pakket->status === 'NietMeerIngeschreven' ? 'disabled' : '' }}>
                        Wijzig status voedselpakket
                    </button>

                    <div class="flex-grow"></div>

                    <a href="{{ url()->previous() }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
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
