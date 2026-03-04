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
                        <input type="radio" name="type" value="pickup" checked class="mr-2">
                        <span>Récupération sur place (Gratuit)</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="type" value="delivery" class="mr-2">
                        <span>Livraison à domicile (+2000 CFA)</span>
                    </label>
                </div>
                @error('type')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
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
            </div>

            <button type="submit" class="w-full bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-600">
                Passer la commande
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const deliveryRadios = document.querySelectorAll('input[name="type"]');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');
    const deliveryFeeElement = document.getElementById('delivery-fee');

    const pricePerKg = {{ (float) $fish->price_per_kg }};
    const deliveryFee = 2000;

    function updateTotal() {
        const quantity = parseInt(quantityInput.value) || 0;
        const isDelivery = document.querySelector('input[name="type"]:checked').value === 'delivery';

        const subtotal = quantity * pricePerKg;
        const total = subtotal + (isDelivery ? deliveryFee : 0);

        subtotalElement.textContent = subtotal.toLocaleString('fr-FR') + ' CFA';
        totalElement.textContent = total.toLocaleString('fr-FR') + ' CFA';

        deliveryFeeElement.style.display = isDelivery ? 'flex' : 'none';
    }

    quantityInput.addEventListener('input', updateTotal);
    deliveryRadios.forEach(radio => radio.addEventListener('change', updateTotal));

    updateTotal();
});
</script>
@endsection
