<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Fish routes - accessible to everyone (visitors)
Route::get('/fish', [FishController::class, 'index'])->name('fish.index');
Route::get('/fish/{fish}', [FishController::class, 'show'])->name('fish.show');

// Dashboard - redirect to fish.index for regular users
Route::get('/dashboard', function () {
    return redirect()->route('fish.index');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Fish comment route - requires authentication
    Route::post('/fish/{fish}/comment', [FishController::class, 'storeComment'])->name('fish.comment.store');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create/{fish}', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/{fish}', [OrderController::class, 'store'])->name('orders.store');

    // Admin routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // Supervision - Vue d'ensemble
        Route::get('/supervision', [AdminController::class, 'supervision'])->name('supervision');
        
        // User management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
        
        // Fish management
        Route::get('/fish', [AdminController::class, 'fishIndex'])->name('fish.index');
        Route::get('/fish/create', [AdminController::class, 'createFish'])->name('fish.create');
        Route::post('/fish', [AdminController::class, 'storeFish'])->name('fish.store');
        Route::get('/fish/{fish}/edit', [AdminController::class, 'editFish'])->name('fish.edit');
        Route::patch('/fish/{fish}', [AdminController::class, 'updateFish'])->name('fish.update');
        Route::delete('/fish/{fish}', [AdminController::class, 'destroyFish'])->name('fish.destroy');
        
        // Order management
        Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
        Route::patch('/orders/{order}/approve', [AdminController::class, 'approveOrder'])->name('orders.approve');
        Route::patch('/orders/{order}/reject', [AdminController::class, 'rejectOrder'])->name('orders.reject');
    });
});

require __DIR__.'/auth.php';
