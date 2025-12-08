<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBarang extends Model
{
    protected $table='jenis_barang';
    protected $primaryKey = 'id_jenis_barang';
    public $timestamps = false;

    protected $fillable=[
        'jenis_barang',

    ];
    public function order(){
        return $this->hasMany(Order::class,'id_jenis_barang');
    }
    public function harga_mitra(){
        return $this->hasMany(HargaMitra::class,'id_jenis_barang');
    }
    public function item_orders(){
        return $this->hasMany(ItemOrder::class,'id_jenis_barang');
    }

}
