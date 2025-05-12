<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminSettingController;

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

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::get('/verify-code', [ForgotPasswordController::class, 'showVerifyCodeForm'])->name('verify-code');
    Route::post('/verify-code', [ForgotPasswordController::class, 'verifyCode']);
    Route::post('/resend-code', [ForgotPasswordController::class, 'resendCode']);
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password.post');



});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Add other protected routes here
});

 Route::get('/hakakses', [App\Http\Controllers\HakaksesController::class, 'index'])->name('hakakses.index')->middleware('superadmin');
    Route::get('/hakakses/edit/{id}', [App\Http\Controllers\HakaksesController::class, 'edit'])->name('hakakses.edit')->middleware('superadmin');
    Route::put('/hakakses/update/{id}', [App\Http\Controllers\HakaksesController::class, 'update'])->name('hakakses.update')->middleware('superadmin');
    Route::delete('/hakakses/delete/{id}', [App\Http\Controllers\HakaksesController::class, 'destroy'])->name('hakakses.delete')->middleware('superadmin');


Route::get('/settings', [SettingController::class, 'index'])->name('settings.index'); // menampilkan semua data
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store'); // menyimpan data baru

// Route untuk menampilkan daftar mahasiswa
Route::get('/setting-admin', [AdminSettingController::class, 'index'])->name('setting_admin.index');

// Route untuk menampilkan halaman edit organisasi mahasiswa
Route::get('/setting-admin/{user}/edit', [AdminSettingController::class, 'edit'])->name('setting_admin.edit');

// Route untuk update organisasi mahasiswa
Route::post('/setting-admin/{user}/update', [AdminSettingController::class, 'update'])->name('setting_admin.update');

