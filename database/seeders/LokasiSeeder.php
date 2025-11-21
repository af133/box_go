<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class LokasiSeeder extends Seeder
{
    public function run()
    {
        DB::table('lokasi')->insert([
            ['id_lokasi' => 1, 'id_mitra' => 1, 'nama_lokasi' => 'Warehouse Kaliwates', 'latitude' => -8.1837, 'longitude' => 113.7010],
            ['id_lokasi' => 2, 'id_mitra' => 2, 'nama_lokasi' => 'Warehouse Patrang',   'latitude' => -8.1617, 'longitude' => 113.7153],
            ['id_lokasi' => 3, 'id_mitra' => 3, 'nama_lokasi' => 'Warehouse Sumbersari','latitude' => -8.1728, 'longitude' => 113.7080],
        ]);

    }
}
