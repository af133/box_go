<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaMitra extends Model
{
    protected $table='harga_mitra';
    protected $primaryKey = 'id_harga_mitra';
    public $timestamps = false;
    protected $fillable=[
        'id_mitra',
        'id_jenis_barang',
        'harga_sewa'
    ];
    public function mitra(){
        return $this->belongsTo(Mitra::class,'id_mitra');
    }
    public function jenis_barang(){
        return $this->belongsTo(JenisBarang::class,'id_jenis_barang');}
}
