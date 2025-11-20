<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use hasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $keyType = 'int';

    protected $fillable = [
        'id_order',
        'tanggal_transaksi',
        'jumlah_pembayaran',
        'status_pembayaran',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
