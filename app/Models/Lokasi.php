<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;
    protected $table = 'lokasi';
    protected $primaryKey = 'id_lokasi';

    protected $fillable = [
        'id_mitra',
        'nama_lokasi',
        'alamat',
        'path_area',
        'deskripsi'

    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
    public function area_gudang()
    {
        return $this->hasMany(AreaGudang::class, 'id_lokasi');
    }
    public function rating_mitra()
    {
        return $this->hasMany(RatingMitra::class, 'id_lokasi');
    }
}
