<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendatang extends Model
{
    protected $table = 'pendatang';

    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'kewarganegaraan',
        'banjar_id',
        'kk_tujuan_id',
        'keterangan',
        'penduduk_id',
        'asal'
    ];

    /**
     * Relasi ke penduduk
     */
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    /**
     * Relasi ke KK tujuan
     */
    public function kkTujuan()
    {
        return $this->belongsTo(KK::class, 'kk_tujuan_id');
    }

    
}
