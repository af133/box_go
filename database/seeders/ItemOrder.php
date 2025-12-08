<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ItemOrder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('item_order')->insert([
            [
                'id_order' => 1,
                'id_jenis_barang' => 1,
                'harga_saat_order' => 12000,
            ],
            [
                'id_order' => 1,
                'id_jenis_barang' => 2,
                'harga_saat_order' => 12000,
            ]
        ]);
    }
}
