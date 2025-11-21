<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    public function run()
    {
        DB::table('mitra')->insert([
            ['id_mitra' => 1, 'id_email' => 1, 'nama' => 'Gudang Kaliwates', 'alamat' => 'Kaliwates, Jember', 'nomor_hp' => '081234567890'],
            ['id_mitra' => 2, 'id_email' => 2, 'nama' => 'Gudang Patrang',   'alamat' => 'Patrang, Jember', 'nomor_hp' => '081234567891'],
            ['id_mitra' => 3, 'id_email' => 3, 'nama' => 'Gudang Sumbersari','alamat' => 'Sumbersari, Jember', 'nomor_hp' => '081234567892'],
        ]);


    }
}
