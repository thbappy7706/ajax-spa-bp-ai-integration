<?php

use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlaceholderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics');
    Route::get('/reports',   [PlaceholderController::class, 'reports'])->name('reports');

// Management
    Route::get('/users',    [UserController::class, 'index'])->name('users');
    Route::get('/users/roles', [UserController::class, 'getRoles'])->name('users.roles');
    Route::post('/users',   [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/roles',    [RoleController::class, 'index'])->name('roles');
    Route::get('/roles/permissions', [RoleController::class, 'getPermissions'])->name('roles.permissions');
    Route::post('/roles',   [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/calendar', [PlaceholderController::class, 'calendar'])->name('calendar');

// Products CRUD (SPA pages + JSON API)
    Route::get('/products',          [ProductController::class, 'index'])->name('products');
    Route::post('/products',         [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/bulk-delete', [ProductController::class, 'bulkDestroy'])->name('products.bulk-destroy');

// CMS
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('posts', \App\Http\Controllers\PostController::class);
    Route::resource('comments', \App\Http\Controllers\CommentController::class);


// Preferences
    Route::get('/profile',    [PlaceholderController::class, 'profile'])->name('profile');
    Route::get('/appearance', [PlaceholderController::class, 'appearance'])->name('appearance');
});

require __DIR__.'/auth.php';
