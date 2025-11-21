<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DetailOrderSeeder extends Seeder
{
    public function run()
    {
        DB::table('detail_order')->insert([
            [
                'id_order' => 1,
                'id_mitra' => 1,
                'path_pembayaran' => null,
                'status' => 'pending',
            ]
        ]);
    }
}
