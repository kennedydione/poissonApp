@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 text-white px-3 py-2 rounded-lg hover:bg-gray-600 flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Retour
        </a>
        <h1 class="text-2xl md:text-3xl font-bold">Gestion des Commandes</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-center">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approuvée</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetée</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Filtrer</button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Téléphone</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Poisson</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Adresse</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $order->user->name }}</div>
                                <div class="text-xs text-gray-400">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->user->phone ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->fish->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->quantity }} kg</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-semibold">
                                {{ number_format($order->total_price, 0, ',', ' ') }} CFA
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->delivery ? 'Livraison' : 'Récupération' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($order->delivery && $order->delivery_address)
                                    <span class="text-xs">{{ Str::limit($order->delivery_address, 30) }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($order->status === 'approved') bg-green-100 text-green-800
                                    @elseif($order->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    @if($order->status === 'approved') Approuvée
                                    @elseif($order->status === 'rejected') Rejetée
                                    @else En attente @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($order->status === 'pending')
                                    <div class="flex items-center gap-2">
                                        <form action="{{ route('admin.orders.approve', $order) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900 font-medium">Approuver</button>
                                        </form>
                                        <button onclick="openRejectModal({{ $order->id }})" class="text-red-600 hover:text-red-900 font-medium">Rejeter</button>
                                    </div>
                                    
                                    <!-- Reject Modal -->
                                    <div id="rejectModal{{ $order->id }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                            <h3 class="text-lg font-bold mb-4">Rejeter la commande #{{ $order->id }}</h3>
                                            <form action="{{ route('admin.orders.reject', $order) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-4">
                                                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Motif du rejet</label>
                                                    <textarea id="rejection_reason" name="rejection_reason" rows="3" required
                                                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500"
                                                        placeholder="Expliquez pourquoi cette commande est rejetée..."></textarea>
                                                </div>
                                                <div class="flex justify-end gap-2">
                                                    <button type="button" onclick="closeRejectModal({{ $order->id }})" 
                                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Annuler</button>
                                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Confirmer le rejet</button>
                                                </div>
                                            </form>
                                        </div>
                                @else
                                    @if($order->rejection_reason)
                                        <button onclick="showRejectionReason('{{ $order->rejection_reason }}')" class="text-gray-500 hover:text-gray-700 text-xs">
                                            Voir motif
                                        </button>
                                    @else
                                        <span class="text-gray-400">Traitée</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                Aucune commande trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Rejection Reason Modal (for viewing) -->
    <div id="viewReasonModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Motif du rejet</h3>
            <p id="rejectionReasonText" class="text-gray-700 mb-4"></p>
            <div class="flex justify-end">
                <button onclick="closeViewReasonModal()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Fermer</button>
            </div>
    </div>

<script>
function openRejectModal(orderId) {
    document.getElementById('rejectModal' + orderId).classList.remove('hidden');
}

function closeRejectModal(orderId) {
    document.getElementById('rejectModal' + orderId).classList.add('hidden');
}

function showRejectionReason(reason) {
    document.getElementById('rejectionReasonText').textContent = reason;
    document.getElementById('viewReasonModal').classList.remove('hidden');
}

function closeViewReasonModal() {
    document.getElementById('viewReasonModal').classList.add('hidden');
}
</script>
@endsection
