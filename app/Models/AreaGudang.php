<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaGudang extends Model
{

    protected $table = 'area_gudang';
    public $timestamps = false;
    protected $fillable = [
        'id_polygon',
        'id_lokasi',
    ];
    public function polygon(){
        return $this->belongsTo(Polygon::class,'id_polygon');
    }
    public function lokasi(){
        return $this->belongsTo(Lokasi::class,'id_lokasi');
    }
}
