<?php

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
|  — Auth Routes
|--------------------------------------------------------------------------
|
| These routes handle authentication for the application. They are loaded
| by the RouteServiceProvider. All are stateful (session-based).
|
*/

// ── GUEST ROUTES (redirect if already authenticated) ──────────────────────
Route::middleware('guest')->group(function () {

    // Login
    Route::get('login',  [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    // Registration
    Route::get('register',  [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);

    // Forgot password
    Route::get('forgot-password',  [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    // Reset password
    Route::get('reset-password/{token}',  [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password',         [NewPasswordController::class, 'store'])->name('password.update');
});

// ── AUTHENTICATED ROUTES ───────────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    // Email verification
    Route::get('verify-email',                [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}',    [EmailVerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('verification.send');

    // Confirm password (for sensitive areas)
    Route::get('confirm-password',  [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Logout
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});
