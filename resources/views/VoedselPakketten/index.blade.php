<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-900 dark:text-gray-100">
                {{ __('Voedselpakketten') }}
            </h2>
            <span class="px-3 py-1 text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                {{ now()->format('d M Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-green-700 dark:text-green-400 text-2xl font-semibold mb-4 underline">Overzicht gezinnen met voedselpakketten</h1>

            <form method="GET" action="{{ route('voedselpakketten.index') }}" class="flex items-center justify-end mb-4 gap-2">
                <select name="eetwens_id" class="border rounded px-3 py-1 text-sm" onchange="this.form.submit()">
                    <option value="">Selecteer Eetwens</option>
                    @foreach($eetwensen as $eetwens)
                        <option value="{{ $eetwens->id }}" {{ request('eetwens_id') == $eetwens->id ? 'selected' : '' }}>
                            {{ $eetwens->naam }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">Toon Gezinnen</button>
                @if(request('eetwens_id'))
                    <a href="{{ route('voedselpakketten.index') }}" class="bg-gray-500 text-white px-4 py-1 rounded hover:bg-gray-600">Reset</a>
                @endif
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 text-sm text-left">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">Gezinsnaam</th>
                            <th class="px-4 py-2 border">Omschrijving</th>
                            <th class="px-4 py-2 border">Volwassenen</th>
                            <th class="px-4 py-2 border">Kinderen</th>
                            <th class="px-4 py-2 border">Babys</th>
                            <th class="px-4 py-2 border">Vertegenwoordiger</th>
                            <th class="px-4 py-2 border">Voedselpakket Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($voedselpakketten as $pakket)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border">{{ $pakket->gezinsnaam }}</td>
                                <td class="px-4 py-2 border">{{ $pakket->omschrijving }}</td>
                                <td class="px-4 py-2 border">{{ $pakket->volwassenen }}</td>
                                <td class="px-4 py-2 border">{{ $pakket->kinderen }}</td>
                                <td class="px-4 py-2 border">{{ $pakket->babys }}</td>
                                <td class="px-4 py-2 border">{{ $pakket->vertegenwoordiger}}</td>
                                <td class="px-4 py-2 border text-center">
                                    <a href="{{ route('voedselpakketten.show', $pakket->voedselpakket_id) }}" class="inline-block">
                                        <svg class="w-5 h-5 text-blue-500 hover:text-blue-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4a2 2 0 0 0 1-1.73z" />
                                            <polyline points="3.27 6.96 12 12.01 20.73 6.96" />
                                            <line x1="12" y1="22.08" x2="12" y2="12" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-2 border text-center text-gray-500 bg-red-100 dark:bg-red-900/50">
                                    Er zijn geen gezinnen bekent die de geselecteerde eetwens hebben
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 text-right">
                <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">home</a>
            </div>
        </div>
    </div>
</x-app-layout>
