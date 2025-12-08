<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    protected $table='polygon';
    protected $primaryKey = 'id_polygon';
    public $timestamps = false;
    protected $fillable=[
        'polygon'
    ];
    public function area_gudang(){
        return $this->hasMany(AreaGudang::class,'id_polygon');
    }
}
