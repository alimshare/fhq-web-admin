<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
*	Kas masuk & keluar (Finance and Accounting)
*	@author : Abdullah 'Alim (alimm.abdullah@gmail.com)
*/
class Transaction extends Model
{
    use SoftDeletes;

    protected $table = "transactions";

    protected $fillable = [
        'tanggal',
        'jenis',
        'kategori',
        'jumlah',
        'keterangan',
        'attachment',
        'created_by',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'decimal:2',
    ];

    const JENIS_MASUK  = 'masuk';
    const JENIS_KELUAR = 'keluar';

    public function isMasuk()
    {
        return $this->jenis === self::JENIS_MASUK;
    }

    /**
     * URL publik untuk file lampiran (jika ada).
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? asset('storage/' . $this->attachment) : null;
    }

    public function scopeMasuk($query)
    {
        return $query->where('jenis', self::JENIS_MASUK);
    }

    public function scopeKeluar($query)
    {
        return $query->where('jenis', self::JENIS_KELUAR);
    }
}
