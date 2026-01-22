<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penduduk;
use App\Models\KK;

class Perkawinan extends Model
{
    protected $table = 'perkawinan';

    protected $fillable = [
        'penduduk_id',
        'nama',
        'nik',
        'nomor_kk',
        'banjar_id',
        'kk_tujuan_id',
        'tipe',
        'tanggal',
        'keterangan',
    ];
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    public function kkTujuan()
    {
        return $this->belongsTo(KK::class, 'kk_tujuan_id');
    }

    public function banjar()
    {
        return $this->belongsTo(Banjar::class);
    }
}
