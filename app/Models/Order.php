<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'order';
    protected $primaryKey = 'id_order';
    protected $keyType = 'int';

    protected $fillable = [
        'id_mitra',
        'status_pemesanan',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function detailOrder()
    {
        return $this->hasMany(DetailOrder::class, 'id_order');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_transaksi');
    }
}
