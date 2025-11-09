<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;
use App\Models\Mitra;
use App\Models\Pelanggan;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class AuthController extends Controller
{
    use HasApiTokens, Notifiable;
    // REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,mitra,pelanggan',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($request->role == 'mitra') {
            $data['nomor_hp'] = $request->nomor_hp;
            $user = Mitra::create($data);
        } elseif ($request->role == 'pelanggan') {
            $data['nomor_hp'] = $request->nomor_hp;
            $user = Pelanggan::create($data);
        } else {
            $user = Admin::create($data);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Register berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // LOGIN
    public function login(Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,mitra,pelanggan',
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($request->role == 'mitra') {
            $user = Mitra::where('email', $request->email)->first();
        } elseif ($request->role == 'pelanggan') {
            $user = Pelanggan::where('email', $request->email)->first();
        } else {
            $user = Admin::where('email', $request->email)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token' => $token,
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}
