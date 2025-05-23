<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminSettingController;
use App\Http\Controllers\PelatihanMahasiswaController;
use App\Http\Controllers\PelatihanAdminController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PendaftaranAdminController;
use App\Http\Controllers\SPKController;

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


Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('mahasiswa'); // menampilkan semua data
Route::post('/settings', [SettingController::class, 'store'])->name('settings.store')->middleware('mahasiswa'); // menyimpan data baru

// Route untuk menampilkan daftar mahasiswa
Route::get('/setting-admin', [AdminSettingController::class, 'index'])->name('setting_admin.index') ->middleware('superadmin');

// Route untuk menampilkan halaman edit organisasi mahasiswa
Route::get('/setting-admin/{user}/edit', [AdminSettingController::class, 'edit'])->name('setting_admin.edit')->middleware('superadmin');

// Route untuk update organisasi mahasiswa
Route::post('/setting-admin/{user}/update', [AdminSettingController::class, 'update'])->name('setting_admin.update')->middleware('superadmin');

// Mahasiswa Pelatihan
Route::get('/mahasiswa/pelatihan', [PelatihanMahasiswaController::class, 'index'])
    ->name('mahasiswa.pelatihan.index')->middleware('mahasiswa');

// Admin Pelatihan
Route::get('/admin/pelatihan', [PelatihanAdminController::class, 'index'])
    ->name('admin.pelatihan.index')->middleware('superadmin');





Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/pendaftaran', [MahasiswaController::class, 'showForm'])
        ->name('mahasiswa.pendaftaran.form');

    Route::post('/mahasiswa/pendaftaran', [MahasiswaController::class, 'submitForm'])
        ->name('mahasiswa.pendaftaran.submit');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/pendaftaran', [PendaftaranAdminController::class, 'index'])->name('admin.pendaftaran.index');
    Route::put('/admin/pendaftaran/{id}/status/{status}', [PendaftaranAdminController::class, 'updateStatus'])->name('admin.pendaftaran.updateStatus');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/spk', [SPKController::class, 'index'])->name('spk.index'); // Halaman intro SPK

    // Form soal per index (1 soal per halaman)
    Route::get('/spk/form/{index}', [SPKController::class, 'showQuestion'])->name('spk.question');
    Route::post('/spk/form/{index}', [SPKController::class, 'storeAnswer'])->name('spk.answer');

    // Hasil & export
    Route::get('/spk/result', [SPKController::class, 'result'])->name('spk.result');
    Route::get('/spk/export-pdf', [SPKController::class, 'exportPdf'])->name('spk.export_pdf');
});

