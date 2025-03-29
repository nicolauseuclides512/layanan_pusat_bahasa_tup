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
// ✅ AUTHENTICATION (LOGIN & LOGOUT)
// =============================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// =============================
// ✅ REGISTRASI MAHASISWA
// =============================
Route::get('/register', [MahasiswaController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [MahasiswaController::class, 'register']);

// =============================
// ✅ DASHBOARD (ADMIN & MAHASISWA)
// =============================
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

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
