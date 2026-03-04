@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">🔍 Supervision</h1>
            <p class="text-gray-600 mt-1">Vue d'ensemble de l'application</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 flex items-center gap-2">
                ← Tableau de Bord
            </a>
        </div>
    </div>

    <!-- Statistiques Générales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Utilisateurs -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Utilisateurs</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $activeUsers }} actifs</p>
                </div>
                <div class="bg-indigo-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Poisson -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Poissons</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalFish }}</p>
                    <p class="text-xs text-orange-600 mt-1">{{ $lowStockItems }} stock faible</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Commandes -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Commandes</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $totalOrders }}</p>
                    <p class="text-xs text-yellow-600 mt-1">{{ $pendingOrders }} en attente</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Revenus Totaux</p>
                    <p class="text-3xl font-bold text-gray-800">{{ number_format($totalRevenue, 0, ',', ' ') }} CFA</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et Activité -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Statut des commandes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">📊 Statut des Commandes</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Approuvées</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-200 rounded-full h-4">
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $totalOrders > 0 ? ($approvedOrders / $totalOrders * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium">{{ $approvedOrders }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">En attente</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-200 rounded-full h-4">
                            <div class="bg-yellow-500 h-4 rounded-full" style="width: {{ $totalOrders > 0 ? ($pendingOrders / $totalOrders * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium">{{ $pendingOrders }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Rejetées</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-200 rounded-full h-4">
                            <div class="bg-red-500 h-4 rounded-full" style="width: {{ $totalOrders > 0 ? ($rejectedOrders / $totalOrders * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium">{{ $rejectedOrders }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">👥 Statut des Utilisateurs</h2>
            <div class="space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Actifs</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-200 rounded-full h-4">
                            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $totalUsers > 0 ? ($activeUsers / $totalUsers * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium">{{ $activeUsers }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Bloqués</span>
                    <div class="flex items-center gap-3">
                        <div class="w-32 bg-gray-200 rounded-full h-4">
                            <div class="bg-red-500 h-4 rounded-full" style="width: {{ $totalUsers > 0 ? ($blockedUsers / $totalUsers * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm font-medium">{{ $blockedUsers }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité Récente -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Commandes récentes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Dernières Commandes
            </h2>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentOrders as $order)
                    <div class="border-b pb-2">
                        <p class="font-semibold text-sm">{{ $order->fish->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-500">{{ $order->user->name ?? 'N/A' }} - {{ $order->quantity }}kg</p>
                        <span class="px-2 py-0.5 rounded text-xs font-medium
                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status === 'approved') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Aucune commande.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.orders.index') }}" class="mt-3 inline-block text-blue-500 hover:underline text-sm">Voir toutes les commandes</a>
        </div>

        <!-- Nouveaux utilisateurs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                Nouveaux Utilisateurs
            </h2>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentUsers as $user)
                    <div class="border-b pb-2">
                        <p class="font-semibold text-sm">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                        <p class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Aucun utilisateur.</p>
                @endforelse
            </div>
            <a href="{{ route('admin.users.index') }}" class="mt-3 inline-block text-blue-500 hover:underline text-sm">Gérer les utilisateurs</a>
        </div>

        <!-- Commentaires récents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                </svg>
                Commentaires Récents
            </h2>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentComments as $comment)
                    <div class="border-b pb-2">
                        <p class="font-semibold text-sm">{{ $comment->user->name ?? 'N/A' }}</p>
                        <p class="text-xs text-gray-600">{{ Str::limit($comment->content, 50) }}</p>
                        <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Aucun commentaire.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
