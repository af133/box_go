<?php

namespace App\Http\Controllers;
use Cloudinary\Cloudinary;
use File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Mitra;
use App\Models\Pelanggan;

class ProfileController extends Controller
{
    public function update(Request $request){
        if ($request->hasFile('path_profil')) {
        $cloudinary = new Cloudinary();
        $cloudinaryResult = $cloudinary->uploadApi()->upload(
                $request->file('path_profil')->getRealPath(),
                [
                    'folder' => 'go_box/'.$request->id_email
                ]
            );
        $cloudinaryUrl = $cloudinaryResult['secure_url'] ?? null;
        }
        $password=null;
        if($request->password){
            $password=Hash::Make($request->password);
        }
        $cloudinaryUrl = $cloudinaryResult['secure_url'] ?? null;
        if ($request->role == 'admin') {

                $admin= Admin::where('id_email',$request->id_email)->update(
                    [
                        'password'=>$password

                        ]
                    );
                    return response()->json([
                        'role' => 'admin',
                        'user' => $admin,
                    ]);
                }
        else if ($request->role == 'mitra') {
            $mitra= Mitra::where('id_email',$request->id_email)->update(
                [
                    'nama'=>$request->nama,
                    'password'=>$password,
                    'alamat'=>$request->alamat??null,
                    'nomor_hp'=>$request->alamat??null,
                    'path_profil'=>$cloudinaryUrl

                ]);
            return response()->json([
                'role' => 'mitra',
                'user' => $mitra,
            ]);
        }
        else if($request->role == 'pelanggan'){
            $pelanggan= Pelanggan::where('id_email',$request->id_email)->update(
                  [
                    'nama'=>$request->nama,
                    'password'=>$password,
                    'alamat'=>$request->alamat??null,
                    'nomor_hp'=>$request->alamat??null,
                    'path_profil'=>$cloudinaryUrl

                ]);
            return response()->json([
                'role'=>$request->role,
                'user'=>$pelanggan
            ]);

        }
    }
}
