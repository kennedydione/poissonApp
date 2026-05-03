<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Fish $fish)
    {
        return view('orders.create', compact('fish'));
    }

    public function store(Request $request, Fish $fish)
    {
        $maxQuantity = $fish->quantity_available > 0 ? $fish->quantity_available : 999;
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $maxQuantity,
            'type' => 'required|in:pickup,delivery',
            'payment_method' => 'required|in:cash,wave,orange_money,free',
            // Validation conditionnelle pour la livraison
            'delivery_address' => 'required_if:type,delivery|string|max:255',
            'delivery_city' => 'required_if:type,delivery|string|max:100',
            'delivery_phone' => 'required_if:type,delivery|string|max:20',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        $totalPrice = $request->quantity * $fish->price_per_kg;

        // Add delivery fee if delivery selected
        if ($request->type === 'delivery') {
            $totalPrice += 2000;
        }

        // Create the order
        Order::create([
            'user_id' => Auth::id(),
            'fish_id' => $fish->id,
            'quantity' => $request->quantity,
            'type' => $request->type,
            'total_price' => $totalPrice,
            'payment_method' => $request->payment_method,
            // Nouveaux champs de livraison
            'delivery_address' => $request->type === 'delivery' ? $request->delivery_address : null,
            'delivery_city' => $request->type === 'delivery' ? $request->delivery_city : null,
            'delivery_phone' => $request->type === 'delivery' ? $request->delivery_phone : null,
            'delivery_notes' => $request->type === 'delivery' ? $request->delivery_notes : null,
        ]);

        // Decrease the fish quantity available
        $fish->quantity_available -= $request->quantity;
        $fish->save();

        return redirect()->route('dashboard')->with('success', 'Commande passée avec succès !');
    }

    public function index()
    {
        $orders = Auth::user()->orders()->with('fish')->get();
        return view('orders.index', compact('orders'));
    }
}
