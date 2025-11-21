<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Pelanggan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggan')->insert([
            [
                'id_email' => 3, // harus sudah ada di tabel email
                'nama' => 'Budi Santoso',
                'path_profil' => null,
                'alamat' => 'Jl. Kalimantan No. 1, Jember',
                'nomor_hp' => '081234567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
