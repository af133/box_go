<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    public function run()
    {
        DB::table('email')->insert([
            ['id_email' => 1, 'email' => 'mitra1@mail.com', 'password' => bcrypt('P@assword123')],
            ['id_email' => 2, 'email' => 'mitra2@mail.com', 'password' => bcrypt('P@assword123')],
            ['id_email' => 3, 'email' => 'mitra3@mail.com', 'password' => bcrypt('P@assword123')],
            ['id_email' => 4, 'email' => 'pelanga@mail.com', 'password' => bcrypt('P@assword123')],
        ]);

    }
}
