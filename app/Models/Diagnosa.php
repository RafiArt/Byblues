<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
    use HasFactory;

    // Define the table name (optional, but can be helpful if needed)
    protected $table = 'diagnosas';

    // Define the fillable fields
    protected $fillable = [
        'user_id',
        'gejala_id',
        'hasil',
        'cf_value',
        'solusi',
        'tanggal'
    ];

    // Relationship with User
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function gejalas()
    {
        return $this->belongsTo(Gejala::class);
    }
}
