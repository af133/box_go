<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $fillable = [
        'id_pelanggan',
        'path_gambar',
        'id_jenis_barang',
        'tanggal_penitipan',
        'tanggal_pengembalian',
        'status'=>'pending'
    ];

    public function jenis_barang(){
        return $this->belongsTo(JenisBarang::class,'id_jenis_barang');
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detailOrders()
    {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }
}
