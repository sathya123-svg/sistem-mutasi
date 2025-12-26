<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    protected $table = 'mutasi';

    protected $fillable = [
        'penduduk_id',
        'jenis_mutasi',
        'tanggal',
        'asal_banjar',
        'tujuan_banjar',
        'keterangan',
    ];

    public function penduduk()
    {
        return $this->belongsTo(Penduduk::class);
    }

        public function asalBanjar()
    {
        return $this->belongsTo(Banjar::class, 'banjar_id');
    }

    public function tujuanBanjar()
    {
        return $this->belongsTo(Banjar::class, 'banjar_id');
    }
}
