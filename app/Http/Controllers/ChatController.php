<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    
    public function index(Request $request)
    {
        $idUser = $request->header('idUser');
        $userType = $request->header('userType');

        if (!$idUser || !$userType) {
            return response()->json(['error' => 'idUser or userType missing'], 400);
        }

        $chats = Chat::with(['messages', 'mitra', 'pelanggan'])
            ->when($userType === 'mitra', fn($q) => $q->where('id_mitra', $idUser))
            ->when($userType === 'pelanggan', fn($q) => $q->where('id_pelanggan', $idUser))
            ->get();

        return response()->json($chats);
    }

    // Ambil detail chat
    public function show(Request $request, $chatId)
    {
        $idUser = $request->header('idUser');
        $userType = $request->header('userType');

        if (!$idUser || !$userType) {
            return response()->json(['error' => 'idUser or userType missing'], 400);
        }

        $chat = Chat::with('messages')
            ->where('id', $chatId)
            ->when($userType === 'mitra', fn($q) => $q->where('id_mitra', $idUser))
            ->when($userType === 'pelanggan', fn($q) => $q->where('id_pelanggan', $idUser))
            ->firstOrFail();

        return response()->json($chat);
    }

    // Kirim pesan
    public function sendMessage(Request $request, $chatId)
    {
        $idUser = $request->header('idUser');
        $userType = $request->header('userType');

        if (!$idUser || !$userType) {
            return response()->json(['error' => 'idUser or userType missing'], 400);
        }

        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::where('id', $chatId)
            ->when($userType === 'mitra', fn($q) => $q->where('id_mitra', $idUser))
            ->when($userType === 'pelanggan', fn($q) => $q->where('id_pelanggan', $idUser))
            ->firstOrFail();

        $msg = Message::create([
            'chat_id' => $chat->id,
            'sender' => $userType,
            'message' => $request->message,
        ]);

        return response()->json($msg);
    }
}
