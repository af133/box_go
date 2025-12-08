<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('orders')->insert([
            [
                'id_pelanggan' => 1,
                'id_lokasi' => 1,
                'path_gambar' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSvo6HMhOf_3PHKU-baly6XDeZ-cQKApO7lww&s',
                'path_pembayaran' => 'https://www.telkomsel.com/sites/default/files/2024-10/Bukti_Pembayaran_Berbentuk_Invoice.png',
                'tanggal_penitipan' => Carbon::now()->format('Y-m-d'),
                'tanggal_pengambilan' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'status' => 'Diterima',
            ]
        ]);
    }
}
