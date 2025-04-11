<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa; // Pastikan model Mahasiswa di-import


class AuthController extends Controller
{
    // 🟢 Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login'); // Blade: resources/views/auth/login.blade.php
    }

    // 🟢 Proses login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Cek di tabel mahasiswa
        $mahasiswa = Mahasiswa::where('email', $request->email)->first();
        if ($mahasiswa && Hash::check($request->password, $mahasiswa->password)) {
            Auth::login($mahasiswa);
            return redirect()->route('dashboard.mahasiswa')->with('success', 'Login berhasil!');
        }

        // Cek di tabel admin
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::login($admin);
            return redirect()->route('dashboard.admin')->with('success', 'Login berhasil!');
        }

        // Jika tidak ada yang cocok
        return redirect()->back()->withErrors(['email' => 'Email atau password salah.']);
    }

    // 🔴 Logout
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Logout berhasil!');
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset_password'); // Buat view untuk form reset password
    }

    public function resetPassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|exists:mahasiswas,email',
            'nim' => 'required|exists:mahasiswas,nim',
            'password' => 'required|min:6|confirmed', // Pastikan ada field password_confirmation di form
        ]);

        // Temukan pengguna berdasarkan email dan NIM
        $mahasiswa = Mahasiswa::where('email', $request->email)
            ->where('nim', $request->nim)
            ->first();

        if ($mahasiswa) {
            // Update password
            $mahasiswa->password = Hash::make($request->password);
            $mahasiswa->save();

            return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login.');
        }

        return redirect()->back()->withErrors(['error' => 'Informasi tidak valid.']);
    }
}
