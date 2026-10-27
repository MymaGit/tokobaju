<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'identity' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string'],
        ], [
            'identity.required' => 'Email atau nomor telepon wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $this->ensureIsNotRateLimited($request, $credentials['identity']);

        $user = User::findByIdentity($credentials['identity']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($this->throttleKey($request, $credentials['identity']));

            throw ValidationException::withMessages([
                'identity' => 'Email/nomor telepon atau kata sandi salah.',
            ]);
        }

        RateLimiter::clear($this->throttleKey($request, $credentials['identity']));

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended(
            $user->isPenjual() ? route('admin.home') : route('home')
        );
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'identity' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'max:72'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.min' => 'Nama lengkap minimal 3 karakter.',
            'identity.required' => 'Email atau nomor telepon wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $identity = trim($data['identity']);
        $isEmail = str_contains($identity, '@');

        if ($isEmail && ! filter_var($identity, FILTER_VALIDATE_EMAIL)) {
            throw ValidationException::withMessages([
                'identity' => 'Format email tidak valid.',
            ]);
        }

        if (! $isEmail) {
            $phone = User::normalizePhone($identity);

            if ($phone === null || strlen($phone) < 10 || strlen($phone) > 15) {
                throw ValidationException::withMessages([
                    'identity' => 'Nomor telepon tidak valid. Contoh: 081234567890.',
                ]);
            }
        }

        if (User::findByIdentity($identity)) {
            throw ValidationException::withMessages([
                'identity' => 'Email atau nomor telepon sudah terdaftar.',
            ]);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $isEmail ? mb_strtolower($identity) : null,
            'phone' => $isEmail ? null : $phone,
            'password' => $data['password'],
            'role' => User::ROLE_PELANGGAN,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registrasi berhasil. Selamat datang, '.$user->name.'.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah keluar dari sistem.');
    }

    private function ensureIsNotRateLimited(Request $request, string $identity): void
    {
        $key = $this->throttleKey($request, $identity);

        if (! RateLimiter::tooManyAttempts($key, 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'identity' => 'Terlalu banyak percobaan masuk. Coba lagi dalam '.$seconds.' detik.',
        ]);
    }

    private function throttleKey(Request $request, string $identity): string
    {
        return mb_strtolower($identity).'|'.$request->ip();
    }
}
