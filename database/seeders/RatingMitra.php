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
            ['id_lokasi' => 1, 'rating' => 5, 'review' => 'Aman dan bersih'],
            ['id_lokasi' => 1, 'rating' => 4, 'review' => 'Pelayanan ramah'],
            ['id_lokasi' => 2, 'rating' => 3, 'review' => 'Cukup luas'],
            ['id_lokasi' => 3, 'rating' => 5, 'review' => 'Sangat cepat dan aman'],
        ]);
    }
}
