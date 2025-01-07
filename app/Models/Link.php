<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Link extends Model
{
    use HasFactory;

    protected $table = 'links';

    protected $fillable = [
        'title',
        'deskripsi',
        'original_url',
        'short_url',
        'password',
        'expiration_date',
        'clicks',
        'active',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clickTrackings()
    {
        return $this->hasMany(ClickTracking::class);
    }

    public function qrcodes(): HasMany
    {
        return $this->hasMany(Qrcodes::class, 'shortlink_id');

    }
}
