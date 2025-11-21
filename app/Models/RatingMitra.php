<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingMitra extends Model
{
    protected $table = 'rating_mitra';
    protected $fillable = [
        'id_lokasi',
        'rating',
        'review',
    ];
    public $timestamps = true;
    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi');
    }
}
