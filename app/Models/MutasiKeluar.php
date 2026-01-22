<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiKeluar extends Model
{
    use HasFactory;

    protected $table = 'mutasi_keluar';

    protected $fillable = [
        'nama',
        'nik',
        'nomor_kk',
        'tanggal_keluar',
        'alasan',
        'tujuan_daerah',
        'banjar_id',
    ];

    /**
     * Relasi ke banjar (opsional)
     */
    public function banjar()
    {
        return $this->belongsTo(Banjar::class);
    }
}
