<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

// Public routes
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    // Authentication routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // Email verification
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])
         ->name('verification.verify');
    Route::post('/verify-email', [AuthController::class, 'verifyEmail'])
         ->name('verification.send');
         Route::post('/resend-code', [AuthController::class, 'resendCode'])->name('resend.code');



    // Password reset
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])
         ->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
    Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])
         ->name('password.verify');
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])
         ->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
         ->name('password.update');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Add other protected routes here
});
