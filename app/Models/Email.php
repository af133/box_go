<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    protected $table='email';
    protected $fillable=[
        'email','password'
    ];
    protected $primaryKey='id_email';
    public $timestamps = false;
    protected $hidden=[
        'password'
    ];
    public function admin(){
        return $this->hasOne(Admin::class,'id_email');
    }
    public function pelanggan(){
        return $this->hasOne(Pelanggan::class,'id_email');
    }
    public function mitra(){
        return $this->hasOne(Mitra::class,'id_email');
    }
}
