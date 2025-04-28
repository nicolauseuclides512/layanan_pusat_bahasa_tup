<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\LaporanController;

// 🟢 Halaman Utama (Redirect ke Login)
Route::get('/', function () {
    return redirect()->route('login');
});

// =============================
// ✅ AUTHENTICATION (LOGIN, REGISTER, FORGOT PASSWORD)
// =============================
Route::middleware('guest')->group(function () {
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('password.update');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:mahasiswa')->group(function () {
        Route::resource('sertifikat', SertifikatController::class);
        Route::get('sertifikat/{sertifikat}/preview', [SertifikatController::class, 'preview'])->name('sertifikat.preview');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('verifikasi', VerifikasiController::class);
        Route::get('verifikasi/{sertifikat}/preview', [VerifikasiController::class, 'preview'])->name('verifikasi.preview');
    });
});

// =============================
// ✅ LUPA PASSWORD
// =============================
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

// =============================
// ✅ DASHBOARD (ADMIN & MAHASISWA)
// =============================
// Rute untuk dashboard mahasiswa
Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa')->middleware('auth:mahasiswa');
// Rute untuk dashboard admin
Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin')->middleware('auth');


// =============================
// ✅ MANAJEMEN SERTIFIKAT (MAHASISWA)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create', [SertifikatController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat', [SertifikatController::class, 'store'])->name('sertifikat.store');
});

// =============================
// ✅ VERIFIKASI SERTIFIKAT (ADMIN)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::post('/verifikasi/{sertifikat}', [VerifikasiController::class, 'updateStatus'])->name('verifikasi.update');
});

// =============================
// ✅ LAPORAN SERTIFIKAT (ADMIN)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});
