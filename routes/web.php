<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\EprtKhususController;

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
    Route::get('login/admin', [AuthController::class, 'showLoginAdminForm'])->name('login.admin');
    Route::post('login/admin', [AuthController::class, 'loginAdmin']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// =============================
// ✅ DASHBOARD (ADMIN & MAHASISWA)
// =============================
// Rute untuk dashboard mahasiswa
Route::middleware('auth:mahasiswa')->group(function () {
    Route::get('/dashboard/mahasiswa', [DashboardController::class, 'mahasiswa'])->name('dashboard.mahasiswa');
    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create', [SertifikatController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat', [SertifikatController::class, 'store'])->name('sertifikat.store');
    Route::get('/sertifikat/{sertifikat}/preview', [SertifikatController::class, 'preview'])->name('sertifikat.preview');
    Route::delete('/sertifikat/{sertifikat}', [SertifikatController::class, 'destroy'])->name('sertifikat.destroy');
    Route::get('/sertifikat/{sertifikat}/edit', [SertifikatController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{sertifikat}', [SertifikatController::class, 'update'])->name('sertifikat.update');
    Route::get('change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('password.update');
});

// Rute untuk dashboard admin
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'admin'])->name('dashboard.admin');
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::put('/verifikasi/{sertifikat}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
    Route::put('/verifikasi/{id}/restore', [VerifikasiController::class, 'restore'])->name('verifikasi.restore');
    Route::get('verifikasi/{sertifikat}/preview', [VerifikasiController::class, 'preview'])->name('verifikasi.preview');
    Route::put('/sertifikat/{sertifikat}/update-nde', [SertifikatController::class, 'updateNde'])->name('sertifikat.update-nde');
    Route::get('/export/sertifikat', [ExportController::class, 'exportSertifikat'])->name('export.sertifikat');
    Route::resource('eprt-khusus', EprtKhususController::class)->parameters(['eprt-khusus' => 'eprtKhusus']);
    Route::resource('mahasiswa', MahasiswaController::class);
});

// Rute untuk logout (bisa diakses oleh admin dan mahasiswa)
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// =============================
// ✅ LUPA PASSWORD
// =============================
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('reset.password.form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');

// =============================
// ✅ MANAJEMEN SERTIFIKAT (MAHASISWA)
// =============================
Route::middleware('auth:mahasiswa')->group(function () {
    Route::get('/sertifikat', [SertifikatController::class, 'index'])->name('sertifikat.index');
    Route::get('/sertifikat/create', [SertifikatController::class, 'create'])->name('sertifikat.create');
    Route::post('/sertifikat', [SertifikatController::class, 'store'])->name('sertifikat.store');
    Route::get('change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('password.update');
    Route::get('/sertifikat/{sertifikat}/preview', [SertifikatController::class, 'preview'])->name('sertifikat.preview');
    Route::delete('/sertifikat/{sertifikat}', [SertifikatController::class, 'destroy'])->name('sertifikat.destroy');
    Route::get('/sertifikat/{sertifikat}/edit', [SertifikatController::class, 'edit'])->name('sertifikat.edit');
    Route::put('/sertifikat/{sertifikat}', [SertifikatController::class, 'update'])->name('sertifikat.update');
});

// =============================
// ✅ VERIFIKASI SERTIFIKAT (ADMIN)
// =============================
Route::middleware('auth:admin')->group(function () {
    Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::put('/verifikasi/{sertifikat}', [VerifikasiController::class, 'update'])->name('verifikasi.update');
    Route::put('/verifikasi/{id}/restore', [VerifikasiController::class, 'restore'])->name('verifikasi.restore');
    Route::get('verifikasi/{sertifikat}/preview', [VerifikasiController::class, 'preview'])->name('verifikasi.preview');
    Route::put('/sertifikat/{sertifikat}/update-nde', [SertifikatController::class, 'updateNde'])->name('sertifikat.update-nde');
});

// =============================
// ✅ LAPORAN SERTIFIKAT (ADMIN)
// =============================
Route::middleware('auth:admin')->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
});

Route::middleware(['auth:web'])->group(function () {
    Route::put('/sertifikat/{sertifikat}/update-nde', [SertifikatController::class, 'updateNde'])->name('sertifikat.update-nde');
});
