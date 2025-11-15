<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table='jenis_barang';
    
    protected $fillable=[
        'jenis_barang'
    ];
    public function order(){
        return $this->hasMany(Order::class,'id_jenis_barang');
    }

}
