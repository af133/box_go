<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PenarikanDana extends Model
{
    use hasFactory;
    protected $table = 'penarikan_danas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_mitra',
        'tanggal_penarikan',
        'jumlah_penarikan',
        'status',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'id_mitra');
    }
}
