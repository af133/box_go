<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    public function run()
    {
         DB::table('jenis_barang')->insert([
            ['id_jenis_barang' => 1, 'jenis_barang' => 'Motor'],
            ['id_jenis_barang' => 2, 'jenis_barang' => 'Mobil'],
        ]);

    }
}
