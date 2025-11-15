<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Mitra extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'mitra';

    protected $fillable = [
        'nama',
        'id_email',
        'nomor_hp',
        'path_profil',
    ];

    public function email(){
        return $this->belongsTo(Email::class,'id_email');
    }
    // Relasi ke Lokasi
    public function lokasis()
    {
        return $this->hasMany(Lokasi::class, 'id_mitra');
    }


    // Relasi ke Chat
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_mitra');
    }
}
