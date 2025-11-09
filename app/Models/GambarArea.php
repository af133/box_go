<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarArea extends Model
{
    use HasFactory;

    protected $table = 'gambar_area';
    protected $primaryKey = 'id_gambar_area';
    protected $keyType = 'int';

    protected $fillable = [
        'id_lokasi',
        'path_gambar',
    ];

    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
