<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaMitraSeeder extends Seeder
{
    public function run()
    {
       DB::table('harga_mitra')->insert([
            ['id_mitra'=>2,'id_jenis_barang'=>2,'harga_sewa'=>30000],
            ['id_mitra'=>3,'id_jenis_barang'=>3,'harga_sewa'=>25000],
            ['id_mitra'=>4,'id_jenis_barang'=>4,'harga_sewa'=>40000],
            ['id_mitra'=>5,'id_jenis_barang'=>5,'harga_sewa'=>45000],
            ['id_mitra'=>6,'id_jenis_barang'=>6,'harga_sewa'=>35000],
            ['id_mitra'=>7,'id_jenis_barang'=>7,'harga_sewa'=>15000],
            ['id_mitra'=>8,'id_jenis_barang'=>8,'harga_sewa'=>55000],
        ]);

    }
}
