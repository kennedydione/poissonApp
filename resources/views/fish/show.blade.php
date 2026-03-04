@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        @if($fish->image)
            <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}" class="w-full h-64 object-cover">
        @endif
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-2">{{ $fish->name }}</h1>
            <p class="text-gray-600 mb-4">{{ $fish->description }}</p>
            <p class="text-2xl font-bold text-green-600 mb-2">{{ number_format($fish->price_per_kg, 0, ',', ' ') }} CFA / kg</p>
            <p class="text-lg text-gray-700 mb-4">Disponible: {{ $fish->quantity_available }} kg</p>

            @if($fish->quantity_available > 0)
                <a href="{{ route('orders.create', $fish) }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600">Commander maintenant</a>
            @else
                <span class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold cursor-not-allowed">Rupture de stock</span>
            @endif
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Commentaires</h2>

        @auth
            <form action="{{ route('fish.comment.store', $fish) }}" method="POST" class="mb-6">
                @csrf
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Ajouter un commentaire</label>
                    <textarea id="comment" name="comment" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Partagez votre avis sur ce poisson..."></textarea>
                </div>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Publier</button>
            </form>
        @else
            <p class="text-gray-600 mb-4">Veuillez <a href="{{ route('login') }}" class="text-blue-500 hover:underline">vous connecter</a> pour laisser un commentaire.</p>
        @endauth

        <div class="space-y-4">
            @forelse($comments as $comment)
                <div class="border-b border-gray-200 pb-4">
                    <div class="flex items-center mb-2">
                        <strong class="text-gray-800">{{ $comment->user->name }}</strong>
                        <span class="text-gray-500 text-sm ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-700">{{ $comment->comment }}</p>
                </div>
            @empty
                <p class="text-gray-500">Aucun commentaire pour le moment. Soyez le premier à commenter!</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
