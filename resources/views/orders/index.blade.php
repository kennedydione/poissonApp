@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Mes Commandes</h1>

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4">
                        <div>
                            <h2 class="text-xl font-semibold">{{ $order->fish->name }}</h2>
                            <p class="text-gray-600">Commandé le {{ $order->created_at->format('d/m/Y') }}</p>
                        </div>
                        <div class="mt-2 md:mt-0">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($order->status === 'approved') bg-green-100 text-green-800
                                @elseif($order->status === 'rejected') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                @if($order->status === 'pending') En attente
                                @elseif($order->status === 'approved') Approuvée
                                @elseif($order->status === 'rejected') Rejetée
                                @else Livrée @endif
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <p class="text-sm text-gray-500">Quantité</p>
                            <p class="font-semibold">{{ $order->quantity }} kg</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Type</p>
                            <p class="font-semibold">{{ $order->type === 'pickup' ? 'Récupération' : 'Livraison' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Prix Total</p>
                            <p class="font-semibold text-green-600">{{ number_format($order->total_price, 0, ',', ' ') }} CFA</p>
                        </div>
                    </div>

                    @if($order->status === 'approved' && $order->approved_at)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-green-800 font-medium">Commande approuvée!</p>
                            <p class="text-green-700 text-sm">Approuvée le {{ $order->approved_at->format('d/m/Y') }}. Veuillez récupérer dans les 4 jours.</p>
                        </div>
                    @elseif($order->status === 'rejected')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-red-800 font-medium">Commande rejetée</p>
                            @if($order->rejection_reason)
                                <p class="text-red-700 text-sm">Motif: {{ $order->rejection_reason }}</p>
                            @endif
                        </div>
                    @elseif($order->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <p class="text-yellow-800 font-medium">En attente d'approbation</p>
                            <p class="text-yellow-700 text-sm">Votre commande est en cours de révision par notre équipe. Vous serez notifié dès l'approbation.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <p class="text-gray-500 text-lg mb-4">Vous n'avez pas encore passé de commande.</p>
            <a href="{{ route('fish.index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600">Voir les poissons</a>
        </div>
    @endif
</div>
@endsection
