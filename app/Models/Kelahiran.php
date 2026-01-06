<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\KK;
use App\Models\Penduduk;
use App\Models\Banjar;

class Kelahiran extends Model
{
    protected $table = 'kelahiran';

    protected $fillable = [
        'nama_bayi',
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
    ];

    // KK tujuan bayi
    public function kkTujuan()
    {
        return $this->belongsTo(KK::class, 'kk_tujuan_id');
    }

    // Penduduk (bayi yang lahir)
    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

    // Banjar
    public function banjar()
    {
        return $this->belongsTo(Banjar::class);
    }
}
