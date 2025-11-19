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
        'nama_lokasi',
        'alamat',
        'path_area',
        'deskripsi'
      
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }


    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_area');
    }
    public function area_gudang()
    {
        return $this->hasMany(AreaGudang::class, 'id_lokasi');
    }
}
