<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisBarangSeeder extends Seeder
{
    public function run()
    {
        DB::table('jenis_barang')->insert([
    ['id_jenis_barang'=>2,'jenis_barang'=>'Makanan'],
    ['id_jenis_barang'=>3,'jenis_barang'=>'Pakaian'],
    ['id_jenis_barang'=>4,'jenis_barang'=>'Dokumen'],
    ['id_jenis_barang'=>5,'jenis_barang'=>'Perabot'],
    ['id_jenis_barang'=>6,'jenis_barang'=>'Otomotif'],
    ['id_jenis_barang'=>7,'jenis_barang'=>'Aksesoris'],
    ['id_jenis_barang'=>8,'jenis_barang'=>'Barang Cair'],
]);

    }
}
