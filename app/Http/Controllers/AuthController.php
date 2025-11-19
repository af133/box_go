<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Email;
use App\Models\Mitra;
use App\Models\Pelanggan;

class AuthController extends Controller
{
    // =================== REGISTER ===================
    public function register(Request $request)
    {
        // Validasi input
        try {
            $validated = $request->validate([
                'role' => 'required|in:admin,mitra,pelanggan',
                'nama' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:email,email',
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/'
                ]
            ], [
                'email.unique' => 'Email sudah terdaftar',
                'nama.required' => 'Nama harus diisi',
                'email.required' => 'Email harus diisi',
                'password.required' => 'Password harus diisi',
                'email.email' => 'Format email tidak valid.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.'
            ]);
        } catch (ValidationException $e) {
            $firstError = collect($e->errors())->flatten()->first();
            return response()->json(['message' => $firstError], 422);
        }

        // Transaction untuk rollback otomatis
        DB::beginTransaction();
        try {
            $email = Email::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->role == 'admin') {
                $user=Admin::create([
                    'id_email' => $email->id_email,
                    'nama' => $request->nama,
                ]);
            } elseif ($request->role == 'pelanggan') {
                $user=Pelanggan::create([
                    'id_email' => $email->id_email,
                    'nama' => $request->nama,
                ]);
            } else {
                $user=Mitra::create([
                    'id_email' => $email->id_email,
                    'nama' => $request->nama,
                ]);
            }

            $user->load('email');

            // Buat token
            $token = $user->createToken('api-token')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'Register berhasil',
                'user' => [
                    'id_user' => $user->id_admin ?? $user->id_mitra ?? $user->id_pelanggan,
                    'nama' => $user->nama,
                    'email' => $user->email->email,
                    'alamat' => $user->alamat ?? null,
                    'latitude' => $user->latitude ?? null,
                    'longitude' => $user->longitude ?? null,
                    'path_profil' => $user->path_profil ?? null,
                    'nomor_hp' => $user->nomor_hp ?? null,
                ],
                'role' => $request->role,
                'token' => $token,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan server: '.$e->getMessage()], 500);
        }
    }

    // =================== LOGIN ===================
   public function login(Request $request)
{
    // Validasi input
    try {
        $validated = $request->validate([
            'role' => 'required|in:admin,mitra,pelanggan',
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'password.required' => 'Password harus diisi',
            'email.email' => 'Format email tidak valid',
        ]);
    } catch (ValidationException $e) {
        $firstError = collect($e->errors())->flatten()->first();
        return response()->json(['message' => $firstError], 422);
    }

    try {
        $emailModel = Email::where('email', $request->email)->first();
        if (!$emailModel || !Hash::check($request->password, $emailModel->password)) {
            return response()->json(['message' => 'Email atau password salah.'], 401);
        }

        // Ambil instance model sesuai role
        $user = match($request->role) {
            'mitra' => Mitra::where('id_email', $emailModel->id_email)->first(),
            'pelanggan' => Pelanggan::where('id_email', $emailModel->id_email)->first(),
            'admin' => Admin::where('id_email', $emailModel->id_email)->first(),
        };

        if (!$user) {
            return response()->json(['message' => 'User tidak ditemukan untuk role ini.'], 404);
        }

        // Pastikan relasi email dimuat
        $user->load('email');

        // Hapus token lama & buat token baru
        $user->tokens()->delete();
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'user' => [
                'id_user' => $user->id_admin ?? $user->id_mitra ?? $user->id_pelanggan,
                'nama' => $user->nama ?? '',
                'email' => $user->email->email ?? '',
                'alamat' => $user->alamat ?? null,
                'latitude' => $user->latitude ?? null,
                'longitude' => $user->longitude ?? null,
                'path_profil' => $user->path_profil ?? null,
                'nomor_hp' => $user->nomor_hp ?? null,
            ],
            'role' => $request->role,
            'token' => $token,
        ], 200);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan server: '.$e->getMessage()], 500);
    }
}



    // =================== LOGOUT ===================
    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return response()->json(['message' => 'Logout berhasil'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat logout'], 500);
        }
    }
}
