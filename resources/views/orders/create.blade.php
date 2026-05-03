@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Commander {{ $fish->name }}</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">{{ $fish->name }}</h2>
            <p class="text-gray-600 mb-2">{{ $fish->description }}</p>
            <p class="text-lg font-bold text-green-600">{{ number_format($fish->price_per_kg, 0, ',', ' ') }} CFA / kg</p>
            <p class="text-sm text-gray-500">Disponible: {{ $fish->quantity_available }} kg</p>
        </div>

        <form action="{{ route('orders.store', ['fish' => $fish->id]) }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantité (kg)</label>
                <input type="number" id="quantity" name="quantity" min="1" max="{{ $fish->quantity_available }}" value="1"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Option de livraison</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="type" value="pickup" checked class="mr-2" onchange="toggleDeliveryFields()">
                        <span>Récupération sur place (Gratuit)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="delivery" class="mr-2" onchange="toggleDeliveryFields()">
                        <span>Livraison à domicile (+2000 CFA)</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Champs d'adresse de livraison -->
            <div id="delivery-fields" class="mb-4" style="display: none;">
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h3 class="font-semibold mb-3 text-blue-800">Adresse de livraison</h3>
                    
                    <div class="mb-3">
                        <label for="delivery_address" class="block text-sm font-medium text-gray-700 mb-1">Adresse complète <span class="text-red-500">*</span></label>
                        <input type="text" id="delivery_address" name="delivery_address" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="Numéro, rue, quartier">
                        @error('delivery_address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="delivery_city" class="block text-sm font-medium text-gray-700 mb-1">Ville/Commune <span class="text-red-500">*</span></label>
                        <select id="delivery_city" name="delivery_city" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Sélectionner une ville</option>
                            <option value="Dakar">Dakar</option>
                            <option value="Pikine">Pikine</option>
                            <option value="Guédiawaye">Guédiawaye</option>
                            <option value="Rufisque">Rufisque</option>
                            <option value="Thiès">Thiès</option>
                            <option value="Mbour">Mbour</option>
                            <option value="Joal">Joal</option>
                            <option value="Saly">Saly</option>
                            <option value="Ouakam">Ouakam</option>
                            <option value="Fann">Fann</option>
                            <option value="Point E">Point E</option>
                            <option value="Mermoz">Mermoz</option>
                            <option value="Sacré Coeur">Sacré Coeur</option>
                            <option value="HLM">HLM</option>
                            <option value="Grand Yoff">Grand Yoff</option>
                            <option value="Parcelles Assainies">Parcelles Assainies</option>
                            <option value="Dieuptioul">Dieuptioul</option>
                            <option value="Keur Massar">Keur Massar</option>
                            <option value="Malika">Malika</option>
                            <option value="Sicap">Sicap</option>
                            <option value="Bargny">Bargny</option>
                            <option value="Sébikhotane">Sébikhotane</option>
                            <option value="Bandia">Bandia</option>
                            <option value=" autre">Autre</option>
                        </select>
                        @error('delivery_city')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="delivery_phone" class="block text-sm font-medium text-gray-700 mb-1">Téléphone pour la livraison <span class="text-red-500">*</span></label>
                        <input type="tel" id="delivery_phone" name="delivery_phone" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                               placeholder="77-xxx-xx-xx">
                        @error('delivery_phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="delivery_notes" class="block text-sm font-medium text-gray-700 mb-1">Instructions spéciales (optionnel)</label>
                        <textarea id="delivery_notes" name="delivery_notes" rows="2" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Instructions pour le livreur, code porte, etc."></textarea>
                        @error('delivery_notes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mode de paiement</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="cash" checked class="mr-2">
                        <span>Espèces (Paiement à la livraison)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="wave" class="mr-2">
                        <span>Wave</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="orange_money" class="mr-2">
                        <span>Orange Money</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="payment_method" value="free" class="mr-2">
                        <span>Free Money</span>
                    </label>
                </div>
                @error('payment_method')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold mb-2">Récapitulatif de la commande</h3>
                <div class="flex justify-between mb-1">
                    <span>Sous-total:</span>
                    <span id="subtotal">0 CFA</span>
                </div>
                <div class="flex justify-between mb-1" id="delivery-fee" style="display: none;">
                    <span>Frais de livraison:</span>
                    <span>2000 CFA</span>
                </div>
                <div class="flex justify-between font-bold text-lg border-t pt-2">
                    <span>Total:</span>
                    <span id="total">0 CFA</span>
                </div>

            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600">
                Passer la commande
            </button>
        </form>
    </div>

<script>
function toggleDeliveryFields() {
    const type = document.querySelector('input[name="type"]:checked').value;
    const deliveryFields = document.getElementById('delivery-fields');
    const deliveryFee = document.getElementById('delivery-fee');
    
    if (type === 'delivery') {
        deliveryFields.style.display = 'block';
        deliveryFee.style.display = 'flex';
        
        // Rendre les champs obligatoires
        document.getElementById('delivery_address').required = true;
        document.getElementById('delivery_city').required = true;
        document.getElementById('delivery_phone').required = true;
    } else {
        deliveryFields.style.display = 'none';
        deliveryFee.style.display = 'none';
        
        // Retirer l'attribut required
        document.getElementById('delivery_address').required = false;
        document.getElementById('delivery_city').required = false;
        document.getElementById('delivery_phone').required = false;
    }
    
    updateTotal();
}

document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const deliveryRadios = document.querySelectorAll('input[name="type"]');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');

    const pricePerKg = {{ (float) $fish->price_per_kg }};
    const deliveryFee = 2000;

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const isDelivery = document.querySelector('input[name="type"]:checked').value === 'delivery';

        const subtotal = quantity * pricePerKg;
        const total = subtotal + (isDelivery ? deliveryFee : 0);

        subtotalElement.textContent = subtotal.toLocaleString('fr-FR') + ' CFA';
        totalElement.textContent = total.toLocaleString('fr-FR') + ' CFA';
    }

    quantityInput.addEventListener('input', updateTotal);
    deliveryRadios.forEach(radio => radio.addEventListener('change', updateTotal));

    updateTotal();
});
</script>
@endsection
