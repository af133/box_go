<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaMitraSeeder extends Seeder
{
    public function run()
    {
       DB::table('harga_mitra')->insert([
            ['id_mitra' => 1, 'id_jenis_barang' => 1, 'harga_sewa' => 12000],
            ['id_mitra' => 1, 'id_jenis_barang' => 2, 'harga_sewa' => 22000],
            ['id_mitra' => 2, 'id_jenis_barang' => 1, 'harga_sewa' => 13000],
            ['id_mitra' => 3, 'id_jenis_barang' => 2, 'harga_sewa' => 25000],
        ]);

    }
}
