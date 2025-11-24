<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LokasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('lokasi')->insert([
        [
            'id_lokasi' => 1, 
            'id_mitra' => 1, 
            'nama_lokasi' => 'Warehouse Kaliwates', 
            'latitude' => -8.1837, 
            'longitude' => 113.7010,
            'path_area' => 'https://i.pinimg.com/1200x/14/ce/f7/14cef7efa4886c49299ae7aeaa9430f2.jpg',
            'deskripsi' => 'Warehouse utama yang berlokasi di area Kaliwates, digunakan untuk penyimpanan barang dalam jumlah besar serta pusat distribusi.'
        ],
        [
            'id_lokasi' => 2, 
            'id_mitra' => 2, 
            'nama_lokasi' => 'Warehouse Patrang',   
            'latitude' => -8.1617, 
            'longitude' => 113.7153, 
            'path_area' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSH_C7pxYO1lhguSeobIMIkhFS_ur6K4Mzp3A&s',
            'deskripsi' => 'Gudang penyimpanan barang di wilayah Patrang, dekat pusat kota sehingga mudah diakses untuk pengiriman cepat.'
        ],
        [
            'id_lokasi' => 3, 
            'id_mitra' => 3, 
            'nama_lokasi' => 'Warehouse Sumbersari',
            'latitude' => -8.1728, 
            'longitude' => 113.7080,
            'path_area' => 'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhd5vmBADWFjIRBcqrXkV4BQ4pkJ4NXIphzWzMtjL8pfoGOLeNgObqvZIFoYNC00x0wdpuTFfdQc0p4HbJWLibAIpMkaTurzYEzM52bIOPFDXAXRmJADY8HM4be_q36jccxfzmcOCZkYMQx/s1600/renovasi-bangunan-gudang-interior-kantor-pinterest.com-dinamis-ruang+dan+rumahku-003.jpg',
            'deskripsi' => 'Warehouse yang berfungsi sebagai pusat penyimpanan sementara serta lokasi pengelolaan barang di daerah Sumbersari.'
        ],
    ]);


    }
}
