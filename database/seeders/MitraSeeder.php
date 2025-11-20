<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    public function run()
    {
        DB::table('mitra')->insert([
            [
                'id_mitra'=>2,'id_email'=>2,'nama'=>'PT Logistik 2',
                'path_profil'=>'profil2.png','alamat'=>'Alamat 2',
                'nomor_hp'=>'0822222222','latitude'=>-7.252,'longitude'=>112.762,
            ],
            [
                'id_mitra'=>3,'id_email'=>3,'nama'=>'PT Logistik 3',
                'path_profil'=>'profil3.png','alamat'=>'Alamat 3',
                'nomor_hp'=>'0833333333','latitude'=>-7.253,'longitude'=>112.763,
            ],
            [
                'id_mitra'=>4,'id_email'=>4,'nama'=>'PT Logistik 4',
                'path_profil'=>'profil4.png','alamat'=>'Alamat 4',
                'nomor_hp'=>'0844444444','latitude'=>-7.254,'longitude'=>112.764,
            ],
            [
                'id_mitra'=>5,'id_email'=>5,'nama'=>'PT Logistik 5',
                'path_profil'=>'profil5.png','alamat'=>'Alamat 5',
                'nomor_hp'=>'0855555555','latitude'=>-7.255,'longitude'=>112.765,
            ],
            [
                'id_mitra'=>6,'id_email'=>6,'nama'=>'PT Logistik 6',
                'path_profil'=>'profil6.png','alamat'=>'Alamat 6',
                'nomor_hp'=>'0866666666','latitude'=>-7.256,'longitude'=>112.766,
            ],
            [
                'id_mitra'=>7,'id_email'=>7,'nama'=>'PT Logistik 7',
                'path_profil'=>'profil7.png','alamat'=>'Alamat 7',
                'nomor_hp'=>'0877777777','latitude'=>-7.257,'longitude'=>112.767,
            ],
            [
                'id_mitra'=>8,'id_email'=>8,'nama'=>'PT Logistik 8',
                'path_profil'=>'profil8.png','alamat'=>'Alamat 8',
                'nomor_hp'=>'0888888888','latitude'=>-7.258,'longitude'=>112.768,
            ],
        ]);


    }
}
