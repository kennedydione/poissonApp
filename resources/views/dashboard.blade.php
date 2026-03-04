<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Message de bienvenue -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-2xl font-bold text-gray-800">Bienvenue, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-600 mt-2">Gérez vos commandes et votre profil</p>
                </div>
            </div>

            <!-- Statistiques utilisateur -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Mes Commandes</p>
                                <p class="text-3xl font-bold text-gray-800">{{ Auth::user()->orders->count() }}</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">Voir mes commandes</a>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">En Attente</p>
                                <p class="text-3xl font-bold text-yellow-600">{{ Auth::user()->orders->where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-500 text-sm">Approuvées</p>
                                <p class="text-3xl font-bold text-green-600">{{ Auth::user()->orders->where('status', 'approved')->count() }}</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liens rapides -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Actions Rapides</h4>
                        <div class="space-y-3">
                            <a href="{{ route('fish.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Voir les poissons disponibles
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Mes commandes
                            </a>
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 text-gray-700 hover:text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Modifier mon profil
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Mes Informations</h4>
                        <div class="space-y-2">
                            <p><span class="font-medium">Nom:</span> {{ Auth::user()->name }}</p>
                            <p><span class="font-medium">Email:</span> {{ Auth::user()->email }}</p>
                            <p><span class="font-medium">Membre depuis:</span> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Poissons disponibles -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Poissons Disponibles</h4>
                    <p class="text-gray-600 mb-4">Découvrez notre sélection de poissons frais</p>
                    <a href="{{ route('fish.index') }}" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Voir tous les poissons</a>
                </div>
            </div>

            <!-- Dernières commandes -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Mes Dernières Commandes</h4>
                    @if(Auth::user()->orders->count() > 0)
                        <div class="space-y-4">
                            @foreach(Auth::user()->orders()->with('fish')->latest()->take(5)->get() as $order)
                                <div class="flex justify-between items-center border-b pb-3">
                                    <div>
                                        <p class="font-semibold">{{ $order->fish->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $order->quantity }}kg - {{ number_format($order->total_price, 0, ',', ' ') }} CFA</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="px-2 py-1 rounded text-xs font-medium
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'approved') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            @if($order->status === 'pending') En attente
                                            @elseif($order->status === 'approved') Approuvée
                                            @else Rejetée @endif
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">{{ $order->created_at->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('orders.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">Voir toutes mes commandes</a>
                    @else
                        <p class="text-gray-500">Vous n'avez pas encore passé de commande.</p>
                        <a href="{{ route('fish.index') }}" class="mt-4 inline-block text-blue-500 hover:underline">Découvrir nos poissons</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
