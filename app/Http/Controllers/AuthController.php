<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Admin;
use App\Models\Email;
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
            'password' => 'required|string|min:8',
        ]);

        $idEmail=Email::create([
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
        ]);
        if ($request->role=='admin'){
            $user= Admin::create([
                'id_email'=>$idEmail->id_email,
                'nama'=>$request->nama,
            ]);
        }
        elseif($request->role=='pelanggan'){
            $user= Pelanggan::create([
                'id_email'=>$idEmail->id_email,
                'nama'=>$request->nama,
            ]);
        }
        else{
            $user= Mitra::create([
                'id_email'=>$idEmail->id_email,
                'nama'=>$request->nama,
            ]);
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
        $Iduser = Email::where('email', $request->email)->first();
        

        if (!$Iduser || !Hash::check($request->password, $Iduser->password)) {
            throw ValidationException::withMessages([
                'message' => ['Email atau password salah.'],
            ]);
        }
        if ($request->role =='mitra'){
            $user = Mitra::where('id_email', $Iduser->id_email)->first();
        } elseif ($request->role=='pelanggan'){
            $user = Pelanggan::where('id_email', $Iduser->id_email)->first();
        } else {
            $user = Admin::where('id_email', $Iduser->id_email)->first();

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
