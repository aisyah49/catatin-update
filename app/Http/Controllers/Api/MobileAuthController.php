<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Token Sanctum untuk aplikasi Android.
 *  - Kata sandi hanya dikirim SATU KALI (saat masuk lewat HTTPS); sesudah itu aplikasi memakai token.
 *  - Token disimpan di database dalam bentuk HASH (SHA-256), jadi bocornya database tidak membocorkan token.
 *  - Token hanya punya kemampuan "sync", kedaluwarsa 30 hari, bisa diperbarui (refresh) dan dicabut (logout).
 *  - Di HP token disimpan terenkripsi (Android Keystore), tidak pernah disentuh JavaScript halaman.
 */
class MobileAuthController extends Controller
{
    private const DAYS = 30;

    public function token(Request $r): JsonResponse
    {
        $d = $r->validate([
            'email'       => 'required|email',
            'password'    => 'required|string',
            'device_name' => 'nullable|string|max:60',
        ]);
        $user = User::where('email', $d['email'])->first();
        if (!$user || !Hash::check($d['password'], $user->password)) {
            return response()->json(['message' => 'Email atau kata sandi salah.'], 422);
        }
        return response()->json($this->issue($user, $d['device_name'] ?? 'android'));
    }

    /** Tukar token yang masih berlaku dengan yang baru (token lama langsung dicabut). */
    public function refresh(Request $r): JsonResponse
    {
        $user = $r->user();
        $name = $user->currentAccessToken()->name;
        $user->currentAccessToken()->delete();
        return response()->json($this->issue($user, $name));
    }

    public function logout(Request $r): JsonResponse
    {
        $r->user()->currentAccessToken()->delete();
        return response()->json(['ok' => true]);
    }

    private function issue(User $user, string $device): array
    {
        $user->tokens()->where('name', $device)->delete();        // satu perangkat = satu token aktif
        $exp = now()->addDays(self::DAYS);
        $t = $user->createToken($device, ['sync'], $exp);
        return [
            'token'      => $t->plainTextToken,
            'expires_at' => $exp->toIso8601String(),
            'user'       => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email],
        ];
    }
}
