<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    use HasFactory;

    protected $table = 'detail_order';
// Schema::create('detail_order', function (Blueprint $table) {
//             $table->id('id_detail');
//             $table->foreignId('id_order')->constrained('orders')->onDelete('cascade');
//             $table->foreignId('id_mitra')->constrained('mitra')->onDelete('cascade');
//             $table->string('path_pembayaran')->nullable();
//             $table->enum('status', ['pending', 'terkonfirmasi'])->default('pending');
//             $table->timestamps();
//         });
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
