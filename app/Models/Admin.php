<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'admin';
    public $timestamps = false;
    protected $fillable = [
        'id_email'
    ];
    protected $primaryKey = 'id_admin';
    public function email(){
        return $this->belongsTo(Email::class,'id_email');
    }
}
