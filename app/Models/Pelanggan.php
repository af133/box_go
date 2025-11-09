<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';

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

    // Relasi ke Chat
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_pelanggan');
    }
}
