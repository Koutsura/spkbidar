<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);

Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
