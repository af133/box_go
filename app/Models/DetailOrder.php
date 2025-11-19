<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_order';

    protected $fillable = [
        'id_order',
        'id_mitra',
        'path_pembayaran',
        'status'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_area');
    }
}
