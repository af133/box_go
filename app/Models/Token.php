<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    
        // Schema::create('personal_access_tokens', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('tokenable');
        //     $table->text('name');
        //     $table->string('token', 64)->unique();
        //     $table->text('abilities')->nullable();
        //     $table->timestamp('last_used_at')->nullable();
        //     $table->timestamp('expires_at')->nullable()->index();
        // });
     public $timestamps = false; 
     protected $table='personal_access_tokens';
     protected $fillable=[
        'tokenable',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at'
     ];
}
