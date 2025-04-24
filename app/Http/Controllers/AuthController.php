<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Mahasiswa;
use Illuminate\Validation\Rules\Password as PasswordRule;

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
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'remember' => ['boolean']
        ]);

        // Add rate limiting
        if (!RateLimiter::tooManyAttempts($request->email, 5)) {
            // Try student authentication
            if (Auth::guard('mahasiswa')->attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                Log::info('Student login successful', ['email' => $request->email]);
                return redirect()->intended(route('dashboard.mahasiswa'))
                    ->with('success', 'Login berhasil!');
            }

            // Try admin authentication
            if (Auth::guard('web')->attempt($credentials, $request->remember)) {
                $request->session()->regenerate();
                Log::info('Admin login successful', ['email' => $request->email]);
                return redirect()->intended(route('dashboard.admin'))
                    ->with('success', 'Login berhasil!');
            }

            RateLimiter::hit($request->email);
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans('auth.failed')]);
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
        $request->validate([
            'email' => ['required', 'email', 'exists:mahasiswas,email'],
            'nim' => ['required', 'exists:mahasiswas,nim'],
            'password' => [
                'required',
                'confirmed',
                PasswordRule::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);

        try {
            $mahasiswa = Mahasiswa::where('email', $request->email)
                ->where('nim', $request->nim)
                ->firstOrFail();

            $mahasiswa->password = Hash::make($request->password);
            $mahasiswa->save();

            Log::info('Password reset successful', ['email' => $request->email]);
            
            return redirect()
                ->route('login')
                ->with('status', 'Password berhasil direset. Silakan login.');
        } catch (\Exception $e) {
            Log::error('Password reset failed', [
                'email' => $request->email,
                'error' => $e->getMessage()
            ]);
            
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mereset password.']);
        }
    }
}
