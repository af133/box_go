<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';
    protected $primaryKey = 'id_mitra';
    protected $keyType = 'int';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'nomor_hp',
        'path_profil',
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'id_mitra');
    }

    // Relasi ke Order
    public function order()
    {
        return $this->hasMany(Order::class, 'id_mitra');
    }

    // Relasi ke Chat
    public function chat()
    {
        return $this->hasMany(Chat::class, 'id_mitra');
    }
}
