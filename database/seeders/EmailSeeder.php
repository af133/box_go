<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmailSeeder extends Seeder
{
    public function run()
    {
        DB::table('email')->insert([
            ['id_email'=>2,'email'=>'mitra2@mail.com','password'=>bcrypt('password')],
            ['id_email'=>3,'email'=>'mitra3@mail.com','password'=>bcrypt('password')],
            ['id_email'=>4,'email'=>'mitra4@mail.com','password'=>bcrypt('password')],
            ['id_email'=>5,'email'=>'mitra5@mail.com','password'=>bcrypt('password')],
            ['id_email'=>6,'email'=>'mitra6@mail.com','password'=>bcrypt('password')],
            ['id_email'=>7,'email'=>'mitra7@mail.com','password'=>bcrypt('password')],
            ['id_email'=>8,'email'=>'mitra8@mail.com','password'=>bcrypt('password')],
        ]);

    }
}
