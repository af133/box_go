<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolygonSeeder extends Seeder
{
    public function run()
    {
        DB::table('polygon')->insert([
            ['id_polygon'=>2,'polygon'=>json_encode([[-7.254,112.764],[-7.255,112.765],[-7.256,112.766]])],
            ['id_polygon'=>3,'polygon'=>json_encode([[-7.257,112.767],[-7.258,112.768],[-7.259,112.769]])],
            ['id_polygon'=>4,'polygon'=>json_encode([[-7.260,112.770],[-7.261,112.771],[-7.262,112.772]])],
            ['id_polygon'=>5,'polygon'=>json_encode([[-7.263,112.773],[-7.264,112.774],[-7.265,112.775]])],
            ['id_polygon'=>6,'polygon'=>json_encode([[-7.266,112.776],[-7.267,112.777],[-7.268,112.778]])],
            ['id_polygon'=>7,'polygon'=>json_encode([[-7.269,112.779],[-7.270,112.780],[-7.271,112.781]])],
            ['id_polygon'=>8,'polygon'=>json_encode([[-7.272,112.782],[-7.273,112.783],[-7.274,112.784]])],
        ]);

    }
}
