<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LokasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('lokasi')->insert([
            ['id_lokasi'=>2,'id_mitra'=>2,'nama_lokasi'=>'Gudang A2','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 2'],
            ['id_lokasi'=>3,'id_mitra'=>3,'nama_lokasi'=>'Gudang A3','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 3'],
            ['id_lokasi'=>4,'id_mitra'=>4,'nama_lokasi'=>'Gudang A4','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 4'],
            ['id_lokasi'=>5,'id_mitra'=>5,'nama_lokasi'=>'Gudang A5','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 5'],
            ['id_lokasi'=>6,'id_mitra'=>6,'nama_lokasi'=>'Gudang A6','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 6'],
            ['id_lokasi'=>7,'id_mitra'=>7,'nama_lokasi'=>'Gudang A7','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 7'],
            ['id_lokasi'=>8,'id_mitra'=>8,'nama_lokasi'=>'Gudang A8','path_area'=>null,'deskripsi'=>'Gudang penyimpanan 8'],
        ]);

    }
}
