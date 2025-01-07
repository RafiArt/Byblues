<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Qrcodes extends Model // Nama model sesuai dengan yang Anda sebutkan
{
    use HasFactory;

    protected $fillable = [
        'qrcode',
        'link',
        'user_id',
        'shortlink_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function link(): BelongsTo
    {
        return $this->belongsTo(Link::class, 'shortlink_id');
    }
}
