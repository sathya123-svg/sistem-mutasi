<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penduduk;
use App\Models\KK;
class Kematian extends Model
{
    protected $table = 'kematian';

    protected $fillable = [
        'penduduk_id',
        'tanggal_kematian',
        'nama',
        'nik',
        'banjar_id',
        'keterangan',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

        public function kk()
    {
        return $this->belongsTo(KK::class, 'kk_id');
    }
}
