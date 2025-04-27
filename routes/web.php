<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});
// Halaman setelah login
Route::middleware('auth')->get('/dashboard', [AuthController::class, 'index'])
     ->name('dashboard');

// Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot Password
Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('forgot-password.post');
Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('verify-code');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.post');

