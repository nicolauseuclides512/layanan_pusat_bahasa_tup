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
use App\Models\User;
use Illuminate\Support\Facades\RateLimiter;

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
        $key = 'login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => "Terlalu banyak percobaan login. Silakan coba lagi dalam {$seconds} detik."]);
        }

        // Try student authentication
        if (Auth::guard('mahasiswa')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            RateLimiter::clear($key);
            Log::info('Student login successful', ['email' => $request->email]);
            return redirect()->intended(route('dashboard.mahasiswa'))
                ->with('success', 'Login berhasil!');
        }

        // Try admin authentication
        if (Auth::guard('web')->attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            RateLimiter::clear($key);
            Log::info('Admin login successful', ['email' => $request->email]);
            return redirect()->intended(route('dashboard.admin'))
                ->with('success', 'Login berhasil!');
        }

        RateLimiter::hit($key);

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

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:mahasiswas,email',
            'password' => 'required|string|min:8|confirmed',
            'jenis_kelamin' => 'required|in:L,P',
            'nim' => 'required|string|unique:mahasiswas,nim',
            'program_studi_id' => 'required|exists:program_studis,id',
            'no_telepon' => 'required|string|max:20',
        ]);

        Mahasiswa::create([
            'nama' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'jenis_kelamin' => $request->jenis_kelamin,
            'nim' => $request->nim,
            'program_studi_id' => $request->program_studi_id,
            'no_hp' => $request->no_telepon,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nim_nip' => 'required|string',
            'name' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Cek ke mahasiswa
        $mahasiswa = \App\Models\Mahasiswa::where('email', $request->email)
            ->where('nim', $request->nim_nip)
            ->where('nama', $request->name)
            ->first();
        if ($mahasiswa) {
            $mahasiswa->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $mahasiswa->save();
            return redirect()->route('login')->with('success', 'Password berhasil direset sebagai Mahasiswa. Silakan login.');
        }

        // Cek ke admin
        $admin = \App\Models\Admin::where('email', $request->email)
            ->where('nip', $request->nim_nip)
            ->where('nama', $request->name)
            ->first();
        if ($admin) {
            $admin->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $admin->save();
            return redirect()->route('login')->with('success', 'Password berhasil direset sebagai Admin. Silakan login.');
        }

        return back()->withErrors(['email' => 'Data tidak ditemukan atau tidak sesuai.']);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password has been changed successfully.');
    }

    public function showRegisterForm()
    {
        $programStudis = \App\Models\ProgramStudi::all();
        return view('auth.register', compact('programStudis'));
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
}
