<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaGudangSeeder extends Seeder
{
    public function run()
    {
        DB::table('area_gudang')->insert([
            ['id_area' => 1, 'id_polygon' => 1, 'id_lokasi' => 1],
            ['id_area' => 2, 'id_polygon' => 2, 'id_lokasi' => 2],
        ]);

    }
}
