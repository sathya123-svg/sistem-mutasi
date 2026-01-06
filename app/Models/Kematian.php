<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penduduk;

class Kematian extends Model
{
    protected $table = 'kematian';

    protected $fillable = [
        'penduduk_id',
        'tanggal_kematian',
        'nama',
        'nik',
        'keterangan',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }
}
