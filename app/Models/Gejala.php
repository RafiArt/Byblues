<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gejala extends Model
{
    use HasFactory;

    // Tentukan kolom yang bisa diisi (mass assignable)
    protected $fillable = [
        'kode',
        'keterangan',
        'kategori',
    ];

    // protected $casts = [
    //     'bobot' => 'float',
    // ];

    public function diagnoses()
    {
        return $this->hasMany(Diagnosa::class);
    }
}
