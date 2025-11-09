<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarArea extends Model
{
    use HasFactory;

    protected $table = 'gambar_area';

    protected $fillable = [
        'path_gambar',
    ];

    // Relasi ke Lokasi
    public function lokasis()
    {
        return $this->hasMany(Lokasi::class, 'id_gambar_area');
    }
}
