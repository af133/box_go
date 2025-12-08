<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    Public function SendMessage(Request $request)
    {
        $request->validate([
            'id_lokasi' => 'required',
            'id_mitra' => 'required',
            'id_pelanggan' => 'required',
            'message' => 'required|string',
        ]);
        


        return response()->json(['message' => 'Message sent successfully']);
    }
}
