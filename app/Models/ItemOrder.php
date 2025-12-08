<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemOrder extends Model
{
    public $timestamps = false;
    protected $table = 'item_order';
    protected $primaryKey = 'id_item_order';
    protected $fillable = [
        'id_order',
        'id_jenis_barang',
        'harga_saat_order',
    ];
    public function order(){
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
    public function jenisBarang(){
        return $this->belongsTo(JenisBarang::class, 'id_jenis_barang', 'id_jenis_barang');
    }
}
