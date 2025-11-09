<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';

    protected $fillable = [
        'id_mitra',
        'nama_tempat',
        'alamat',
        'area',
        'id_gambar_area',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }

    public function gambarArea()
    {
        return $this->belongsTo(GambarArea::class, 'id_gambar_area');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_area');
    }
}
