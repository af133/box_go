<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class OrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('order')->insert([
            [
                'id_pelanggan' => 1,
                'path_gambar' => null,
                'id_jenis_barang' => 1,
                'tanggal_penitipan' => Carbon::now()->format('Y-m-d'),
                'id_lokasi' => 1,
                'tanggal_pengambilan' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'status' => 'pending'
            ]
        ]);
    }
}
