@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold mb-6">Modifier le Poisson</h1>

    <form action="{{ route('admin.fish.update', $fish) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
            <input type="text" name="name" id="name" value="{{ old('name', $fish->name) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="price_per_kg" class="block text-sm font-medium text-gray-700">Prix par kg (€)</label>
            <input type="number" step="0.01" name="price_per_kg" id="price_per_kg" value="{{ old('price_per_kg', $fish->price_per_kg) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="quantity_available" class="block text-sm font-medium text-gray-700">Quantité disponible (kg)</label>
            <input type="number" name="quantity_available" id="quantity_available" value="{{ old('quantity_available', $fish->quantity_available) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('description', $fish->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
            <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full">
            @if($fish->image)
                <img src="{{ asset('storage/' . $fish->image) }}" alt="{{ $fish->name }}" class="mt-2 w-32 h-32 object-cover rounded">
            @endif
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('admin.fish.index') }}" class="text-gray-600 hover:text-gray-800">
                ← Retour à la liste
            </a>
            <div class="flex gap-3">
                <button type="button" onclick="confirmDelete()" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Supprimer
                </button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Mettre à jour</button>
            </div>
        </div>
    </form>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Confirmer la suppression</h3>
            <p class="text-gray-700 mb-4">Êtes-vous sûr de vouloir supprimer "{{ $fish->name }}" ? Cette action est irréversible.</p>
            <div class="flex justify-end gap-2">
                <button onclick="closeDeleteModal()" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Annuler</button>
                <form action="{{ route('admin.fish.destroy', $fish) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
