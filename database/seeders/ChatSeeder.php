<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chat;
use App\Models\Message;

class ChatSeeder extends Seeder
{
    public function run(): void
    {

        $chat = Chat::create([
            'id_mitra' => 1,
            'id_pelanggan' => 1,
        ]);

        
        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'mitra',
            'message' => 'Halo, ini pesan dari mitra.',
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'pelanggan',
            'message' => 'Halo, ini balasan dari pelanggan.',
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'sender' => 'mitra',
            'message' => 'Bagaimana kabarnya hari ini?',
        ]);
    }
}
