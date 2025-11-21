<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolygonSeeder extends Seeder
{
    public function run()
    {
        DB::table('polygon')->insert([
            [
                'id_polygon' => 1,
                'polygon' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [
                        [
                            [113.7005, -8.1833],
                            [113.7015, -8.1833],
                            [113.7015, -8.1843],
                            [113.7005, -8.1843],
                            [113.7005, -8.1833]
                        ]
                    ]
                ]),
            ],
            [
                'id_polygon' => 2,
                'polygon' => json_encode([
                    "type" => "Polygon",
                    "coordinates" => [
                        [
                            [113.7148, -8.1613],
                            [113.7158, -8.1613],
                            [113.7158, -8.1623],
                            [113.7148, -8.1623],
                            [113.7148, -8.1613]
                        ]
                    ]
                ]),
            ],
        ]);

    }
}
