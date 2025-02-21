<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak sesuai dengan konvensi Laravel
    protected $table = 'news';

    // Tentukan kolom mana yang boleh diisi (mass assignment)
    protected $fillable = [
        'title', 'content', 'author', 'image_url'
    ];

    // Tentukan kolom yang tidak bisa diisi (optional)
    protected $guarded = [
        'id',
    ];

    // Tentukan format waktu yang digunakan
    protected $dates = ['created_at', 'updated_at'];
}
