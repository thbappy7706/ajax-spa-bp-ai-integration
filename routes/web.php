<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/reports',   [PlaceholderController::class, 'reports'])->name('reports');

// Management
    Route::get('/users',    [PlaceholderController::class, 'users'])->name('users');
    Route::get('/calendar', [PlaceholderController::class, 'calendar'])->name('calendar');

// Products CRUD (SPA pages + JSON API)
    Route::get('/products',          [ProductController::class, 'index'])->name('products');
    Route::post('/products',         [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');

// System
    Route::get('/settings', [PlaceholderController::class, 'settings'])->name('settings');
    Route::get('/security', [PlaceholderController::class, 'security'])->name('security');
});

require __DIR__.'/auth.php';
