<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AreaGudang extends Model
{
    // Schema::create('area_gudang', function (Blueprint $table) {
    //         $table->id('id_area');
    //         $table->foreign('id_polygon')->references('id_polygon')->on('polygon')->onDelete('cascade');
    //         $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
    //     });
    protected $table = 'area_gudang';
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
