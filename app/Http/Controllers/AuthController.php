<?php

// Controller autentikasi sederhana yang menangani register/login/logout.
// Catatan: Admin dibuat dengan kode undangan (ENV ADMIN_INVITE) agar tidak terlihat publik.

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validasi input pendaftaran. 'invite' opsional untuk admin.
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'invite' => ['nullable', 'string'],
        ]);

        // Tentukan role berdasarkan kecocokan kode undangan rahasia.
        $role = 'user';
        $invite = $data['invite'] ?? null;
        $secret = env('ADMIN_INVITE');
        if ($secret && $invite && hash_equals((string) $secret, (string) $invite)) {
            $role = 'admin';
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $role,
        ]);

        // Login otomatis setelah pendaftaran.
        Auth::login($user);

        // Kembalikan hasil beserta role untuk navigasi frontend.
        return response()->json(['ok' => true, 'role' => $user->role]);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $email = trim((string) ($data['email'] ?? ''));
        $password = (string) ($data['password'] ?? '');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['ok' => false, 'error' => 'User tidak ditemukan'], 422);
        }
        if (!Hash::check($password, $user->password)) {
            return response()->json(['ok' => false, 'error' => 'Password salah'], 422);
        }

        Auth::login($user);
        $request->session()->regenerate();
        return response()->json(['ok' => true, 'role' => $user->role]);
    }

    public function logout(Request $request)
    {
        // Logout dan invalidasi sesi.
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
