<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaGudangSeeder extends Seeder
{
    public function run()
    {
        DB::table('area_gudang')->insert([
            [ 'id_polygon'=>2, 'id_lokasi'=>2],
            [ 'id_polygon'=>3, 'id_lokasi'=>3],
            [ 'id_polygon'=>4, 'id_lokasi'=>4],
            [ 'id_polygon'=>5, 'id_lokasi'=>5],
            [ 'id_polygon'=>6, 'id_lokasi'=>6],
            [ 'id_polygon'=>7, 'id_lokasi'=>7],
            [ 'id_polygon'=>8, 'id_lokasi'=>8],
        ]);

    }
}
