<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    protected $fillable = [
        'id_pelanggan',
        'path_gambar',
        'path_pembayaran',
        'id_jenis_barang',
        'id_lokasi',
        'tanggal_penitipan',
        'tanggal_pengembalian',
        'status'
    ];

    public $timestamps = false;

    protected $attributes = [
        'status' => 'pending' // default value
    ];

    public function jenis_barang()
    {
        return $this->belongsTo(JenisBarang::class,'id_jenis_barang');
    }
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_transaksi');
    }
}
