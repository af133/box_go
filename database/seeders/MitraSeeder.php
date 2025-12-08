<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    public function run()
    {
        DB::table('mitra')->insert([
            ['id_mitra' => 1, 'id_email' => 1, 'nama' => 'Andre Firmansyah','path_profil'=>'https://screenscore.digitalmama.id/wp-content/uploads/2025/05/Nprofile2.jpg', 'alamat' => 'Kaliwates, Jember', 'nomor_hp' => '081234567890'],
            ['id_mitra' => 2, 'id_email' => 2, 'nama' => 'Gudang Patrang',   'alamat' => 'Patrang, Jember', 'nomor_hp' => '081234567891','path_profil'=>'https://screenscore.digitalmama.id/wp-content/uploads/2025/05/Nprofile2.jpg'],
            ['id_mitra' => 3, 'id_email' => 3, 'nama' => 'Gudang Sumbersari','alamat' => 'Sumbersari, Jember', 'nomor_hp' => '081234567892','path_profil'=>'https://screenscore.digitalmama.id/wp-content/uploads/2025/05/Nprofile2.jpg'],
        ]);


    }
}
