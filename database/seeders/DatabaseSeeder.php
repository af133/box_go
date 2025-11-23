<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\EmailSeeder;
use Database\Seeders\MitraSeeder;
use Database\Seeders\LokasiSeeder;
use Database\Seeders\PolygonSeeder;
use Database\Seeders\AreaGudangSeeder;
use Database\Seeders\JenisBarangSeeder;
use Database\Seeders\HargaMitraSeeder;
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            EmailSeeder::class,
            Pelanggan::class,
            MitraSeeder::class,
            AdminSeeder::class,
            JenisBarangSeeder::class,
            LokasiSeeder::class,
            PolygonSeeder::class,
            AreaGudangSeeder::class,
            RatingMitra::class,
            HargaMitraSeeder::class,
            OrderSeeder::class,
            DetailOrderSeeder::class,
        ]
    );
    }
}
