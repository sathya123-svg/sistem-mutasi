<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banjar extends Model
{
    use HasFactory;

    protected $table = 'banjar';

    protected $fillable = ['nama'];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class);
    }
}
