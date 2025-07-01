<x-app-layout>
    <div class="py-12">
        <div class="max-w-lg mx-auto">
            <h2 style="color: green; font-size: 2rem; margin-bottom: 2rem; text-decoration: underline; font-weight: bold;">
                Wijzig Product
            </h2>
            @if(session('success'))
                <div style="background: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; border-radius: 4px; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; margin-bottom: 1rem;">
                    <ul style="margin: 0; padding-left: 1.2em;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('leveranciers.product.update', [$leverancier->id, $product->id]) }}">
                @csrf
                @method('PUT')
                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <label for="houdbaarheidsdatum" style="font-weight: bold; font-size: 1.1rem; min-width: 200px;">
                        Houdbaarheidsdatum:
                    </label>
                    <input type="date" id="houdbaarheidsdatum" name="houdbaarheidsdatum"
                        value="{{ old('houdbaarheidsdatum', $product->houdbaarheidsdatum ? \Carbon\Carbon::parse($product->houdbaarheidsdatum)->format('Y-m-d') : '') }}"
                        required style="padding: 10px; font-size: 1.1rem; border-radius: 6px; border: 1px solid #ccc; min-width: 220px;">
                    <button type="submit" style="background: #6c757d; color: white; border: none; padding: 12px 24px; border-radius: 7px; font-size: 1.1rem;">
                        Wijzig Houdbaarheidsdatum
                    </button>
                </div>
                <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                    <a href="{{ route('leveranciers.show', $leverancier->id) }}" style="background: #0d6efd; color: white; padding: 10px 22px; border-radius: 7px; text-decoration: none;">Terug</a>
                    <a href="{{ route('/') }}" style="background: #0d6efd; color: white; padding: 10px 22px; border-radius: 7px; text-decoration: none;">Home</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>