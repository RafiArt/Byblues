<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClickTracking extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'ip_address', 'device_type'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
