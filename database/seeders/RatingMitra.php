<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RatingMitra extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('rating_mitra')->insert([
            ['id_lokasi' => 1, 'rating' => 5, 'review' => 'Aman dan bersih','id_pelanggan'=>1],
        ]);
    }
}
