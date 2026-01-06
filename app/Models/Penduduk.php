<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';


    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'banjar_id',
        'kewarganegaraan',
        'kk_id',
        // 'desa',
        // 'kecamatan',
        // 'kabupaten',
        // 'provinsi',
        // 'agama',
    ];

    // Relasi ke KK
    public function kk()
    {
        return $this->belongsTo(KK::class, 'kk_id');
    }

    // Relasi ke Banjar
    public function banjar()
    {
        return $this->belongsTo(Banjar::class, 'banjar_id', 'id');
    }

    // Relasi ke tabel lain (kelahiran / kematian / pendatang)
    // public function kelahiran()
    // {
    //     return $this->hasOne(Kelahiran::class,);
    // }

    // public function kematian()
    // {
    //     return $this->hasOne(Kematian::class,);
    // }

    // public function pendatang()
    // {
    //     return $this->hasOne(Pendatang::class);
    // }

    // public function perkawinan()
    // {
    //     return $this->hasMany(Perkawinan::class);
    // }
}
