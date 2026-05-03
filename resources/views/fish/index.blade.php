@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('home') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour
        </a>
        <h1 class="text-3xl font-bold">Poissons Disponibles</h1>
    </div>

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
