<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DaftarUlang extends Model
{
    use SoftDeletes;
    
    protected     $table         = "daftar_ulang";

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id', 'id');
    }

    public function nextPeserta()
    {
        return $this->belongsTo(Peserta::class, 'next_peserta_id', 'id');
    }
}
