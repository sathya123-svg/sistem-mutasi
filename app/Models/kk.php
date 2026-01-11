<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Penduduk;
use App\Models\Banjar;

class KK extends Model
{
    protected $table = 'kks';

    protected $fillable = [
        'nomor_kk',
        'kepala_keluarga',
        'banjar_id'
    ];

    // relasi kepala keluarga
    public function kepalaKeluargaPenduduk()
    {
        return $this->belongsTo(Penduduk::class, 'kepala_keluarga');
    }

    // anggota keluarga
    public function anggota()
    {
        return $this->hasMany(Penduduk::class, 'kk_id');
    }

    // relasi banjar
    public function banjar()
    {
        return $this->belongsTo(Banjar::class);
    }

    public function penduduk()
{
    return $this->hasMany(Penduduk::class, 'kk_id');
}

}
