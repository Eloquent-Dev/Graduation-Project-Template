<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThrottleLog extends Model
{
    protected $fillable = [
        'ip_address',
        'url',
        'middleware',
        'method',
        'user_id',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
