<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
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

    // Relasi ke Chat
    public function chat()
    {
        return $this->hasMany(Chat::class, 'id_pelanggan');
    }
}
