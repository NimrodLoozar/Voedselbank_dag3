<x-app-layout>
    <div class="py-12">
        <div class="max-w-md mx-auto">
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
                <div style="display: flex; align-items: center; gap: 1.2rem;">
                    <label for="houdbaarheidsdatum" style="font-weight: bold; font-size: 1rem; min-width: 140px;">
                        Houdbaarheidsdatum:
                    </label>
                    <input type="date" id="houdbaarheidsdatum" name="houdbaarheidsdatum"
                        value="{{ old('houdbaarheidsdatum', $product->houdbaarheidsdatum ? \Carbon\Carbon::parse($product->houdbaarheidsdatum)->format('Y-m-d') : '') }}"
                        required style="padding: 7px; font-size: 1rem; border-radius: 5px; border: 1px solid #ccc; min-width: 140px;">
                </div>
                <div style="margin-top: 1.5rem; display: flex; gap: 0.8rem; align-items: center;">
                    <button type="submit" style="background: #6c757d; color: white; border: none; padding: 10px 18px; border-radius: 7px; font-size: 1rem; font-weight: 500;">
                        Wijzig Houdbaarheidsdatum
                    </button>
                    <a href="{{ route('leveranciers.show', $leverancier->id) }}" style="background: #1677ff; color: white; padding: 10px 18px; border-radius: 7px; text-decoration: none; font-size: 1rem; font-weight: 500;">Terug</a>
                    <a href="{{ route('/') }}" style="background: #1677ff; color: white; padding: 10px 18px; border-radius: 7px; text-decoration: none; font-size: 1rem; font-weight: 500;">Home</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>