@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Poissons Disponibles</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($fish as $fishItem)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($fishItem->image)
                    <img src="{{ asset('storage/' . $fishItem->image) }}" alt="{{ $fishItem->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500">Pas d'image</span>
                    </div>
                @endif
                <div class="p-4">
                    <h2 class="text-xl font-semibold mb-2">{{ $fishItem->name }}</h2>
                    <p class="text-gray-600 mb-2">{{ Str::limit($fishItem->description, 100) }}</p>
                    <p class="text-lg font-bold text-green-600 mb-2">{{ number_format($fishItem->price_per_kg, 0, ',', ' ') }} CFA / kg</p>
                    <p class="text-sm text-gray-500 mb-4">Disponible: {{ $fishItem->quantity_available }} kg</p>
                    <a href="{{ route('fish.show', $fishItem) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 block text-center">Voir les détails</a>
                </div>
            </div>
        @empty
            <p class="col-span-full text-center text-gray-500">Aucun poisson disponible pour le moment.</p>
        @endforelse
    </div>
</div>
@endsection
