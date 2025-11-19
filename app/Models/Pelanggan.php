<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'pelanggan';
    public $timestamps = false;
    protected $fillable = [
        'nama',
        'id_email',
        'nomor_hp',
        'alamat',
        'path_profil',
    ];
     protected $primaryKey = 'id_pelanggan';
    public function email(){
        return $this->belongsTo(Email::class,'id_email');
    }
    // Relasi ke Chat
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_pelanggan');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'id_pelanggan');
    }
}
