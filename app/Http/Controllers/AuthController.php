<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\DbGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

/**
 * Daftar / masuk / keluar pengguna (sesi Laravel biasa + cookie).
 *  - Kata sandi disimpan sebagai hash bcrypt (cast 'hashed' di model User), tidak pernah teks asli.
 *  - Percobaan masuk dibatasi (throttle di routes/web.php) supaya kata sandi tidak bisa ditebak berulang.
 *  - Pendaftaran bisa dimatikan dengan variabel lingkungan CATATIN_REGISTER=false.
 */
class AuthController extends Controller
{
    private function registerOpen(): bool
    {
        return filter_var(env('CATATIN_REGISTER', true), FILTER_VALIDATE_BOOLEAN);
    }

    public function showLogin()
    {
        return view('auth.login', ['registerOpen' => $this->registerOpen()]);
    }

    public function login(Request $r): RedirectResponse
    {
        $cred = $r->validate(
            ['email' => 'required|email', 'password' => 'required'],
            ['email.required' => 'Email wajib diisi.', 'email.email' => 'Format email tidak benar.', 'password.required' => 'Kata sandi wajib diisi.']
        );
        if (!Auth::attempt($cred, $r->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau kata sandi salah.'])->onlyInput('email');
        }
        $r->session()->regenerate();
        return redirect()->intended('/');
    }

    public function showRegister()
    {
        abort_unless($this->registerOpen(), 404);
        return view('auth.register');
    }

    public function register(Request $r): RedirectResponse
    {
        abort_unless($this->registerOpen(), 404);
        $data = $r->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(6)],
        ], [
            'name.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak benar.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan masuk.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sama.',
            'password.min'       => 'Kata sandi minimal 6 karakter.',
        ]);

        // Akun baru selalu mulai KOSONG. Data lama dimiliki akun bawaan (dibuat oleh catatin:setup).
        $user = User::create($data);

        Auth::login($user);
        $r->session()->regenerate();
        return redirect('/');
    }

    public function logout(Request $r): JsonResponse
    {
        Auth::logout();
        $r->session()->invalidate();
        $r->session()->regenerateToken();
        return response()->json(['ok' => true]);
    }

    /** Info pengguna yang sedang login (dipakai kotak "Keluar" di sidebar). */
    public function me(): JsonResponse
    {
        $u = Auth::user();
        return response()->json(['id' => $u->id, 'name' => $u->name, 'email' => $u->email]);
    }
}
