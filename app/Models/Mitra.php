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
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'id_email',
        'nomor_hp',
        'path_profil',
        'alamat',

    ];
     protected $primaryKey = 'id_mitra';

    public function email(){
        return $this->belongsTo(Email::class,'id_email');
    }
    // Relasi ke Lokasi
    public function lokasi()
    {
        return $this->hasMany(Lokasi::class, 'id_mitra');
    }

    // Relasi ke Chat
    public function chat()
    {
        return $this->hasMany(Chat::class, 'id_mitra');
    }
    // Relasi ke HargaMitra
    public function harga_mitra(){
        return $this->hasMany(HargaMitra::class,'id_mitra');}
}
