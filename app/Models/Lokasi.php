<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';
    protected $keyType = 'int';

    protected $fillable = [
        'id_mitra',
        'nama_tempat',
        'alamat',
        'area',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }

    public function gambarArea()
    {
        return $this->hasMany(GambarArea::class, 'id_lokasi');
    }

    public function order()
    {
        return $this->hasMany(DetailOrder::class, 'id_lokasi');
    }
}
