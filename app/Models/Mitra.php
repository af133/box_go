<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $table = 'mitra';

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
    public function lokasis()
    {
        return $this->hasMany(Lokasi::class, 'id_mitra');
    }

    // Relasi ke Order
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_mitra');
    }

    // Relasi ke Chat
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_mitra');
    }
}
