<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Banjar;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   


class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik', 
        'nama', 
        'alamat', 
        'jenis_kelamin', 
        'tanggal_lahir', 
        'banjar_id',
    ];

    public function banjar()
    {
        return $this->belongsTo(Banjar::class);
    }

    public function mutasi()
{
    return $this->hasMany(Mutasi::class);
}

}
