<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Models\Order;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $fish = Fish::all();
        $orders = Order::with('user', 'fish')->get();
        
        // Statistiques supplémentaires
        $totalRevenue = $orders->where('status', 'approved')->sum('total_price');
        $pendingOrders = $orders->where('status', 'pending');
        $recentOrders = Order::with('user', 'fish')->latest()->take(5)->get();
        $lowStockFish = Fish::where('quantity_available', '<', 5)->get();
        
        return view('admin.dashboard', compact('fish', 'orders', 'totalRevenue', 'pendingOrders', 'recentOrders', 'lowStockFish'));
    }

    // Supervision - Vue d'ensemble de l'application
    public function supervision()
    {
        // Statistiques générales
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $blockedUsers = User::where('is_active', false)->count();
        
        $totalFish = Fish::count();
        $totalStock = Fish::sum('quantity_available');
        $lowStockItems = Fish::where('quantity_available', '<', 5)->count();
        
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $approvedOrders = Order::where('status', 'approved')->count();
        $rejectedOrders = Order::where('status', 'rejected')->count();
        
        $totalRevenue = Order::where('status', 'approved')->sum('total_price');
        
        // Activité récente
        $recentOrders = Order::with('user', 'fish')->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();
        $recentComments = Comment::with('user', 'fish')->latest()->take(10)->get();
        
        // Commandes par jour (7 derniers jours)
        $ordersByDay = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        // Revenus par jour
        $revenueByDay = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->where('status', 'approved')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        return view('admin.supervision', compact(
            'totalUsers', 'activeUsers', 'blockedUsers',
            'totalFish', 'totalStock', 'lowStockItems',
            'totalOrders', 'pendingOrders', 'approvedOrders', 'rejectedOrders',
            'totalRevenue', 'recentOrders', 'recentUsers', 'recentComments',
            'ordersByDay', 'revenueByDay'
        ));
    }

    // Gestion des utilisateurs
    public function users()
    {
        $users = User::withCount('orders')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    // Activer/Désactiver un utilisateur
    public function toggleUserStatus(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'Impossible de désactiver un administrateur.');
        }
        
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'activé' : 'désactivé';
        return back()->with('success', "Utilisateur $status avec succès.");
    }

    public function createFish()
    {
        return view('admin.fish.create');
    }

    public function storeFish(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('fish', 'public');
        }

        Fish::create([
            'name' => $request->name,
            'price_per_kg' => $request->price_per_kg,
            'quantity_available' => $request->quantity_available,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Poisson ajouté avec succès.');
    }

    public function editFish(Fish $fish)
    {
        return view('admin.fish.edit', compact('fish'));
    }

    public function updateFish(Request $request, Fish $fish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price_per_kg' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('fish', 'public');
        }

        $fish->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Poisson mis à jour.');
    }

    public function destroyFish(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Poisson supprimé.');
    }

    public function orders()
    {
        $orders = Order::with('user', 'fish')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function approveOrder(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Commande déjà traitée.');
        }

        $order->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        // Decrease quantity
        $fish = $order->fish;
        $fish->decrement('quantity_available', $order->quantity);

        return back()->with('success', 'Commande approuvée.');
    }

    public function rejectOrder(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Commande déjà traitée.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $order->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
            'rejected_at' => now(),
        ]);

        return back()->with('success', 'Commande rejetée.');
    }

    // Page dédiée pour gérer tous les poissons
    public function fishIndex()
    {
        $fish = Fish::paginate(10);
        return view('admin.fish.index', compact('fish'));
    }
}
