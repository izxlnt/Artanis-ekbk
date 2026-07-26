<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemLicense extends Model
{
    protected $fillable = [
        'is_locked',
        'nonce',
        'locked_message',
        'locked_at',
        'locked_reason',
        'unlocked_at',
    ];

    protected $casts = [
        'is_locked'   => 'boolean',
        'locked_at'   => 'datetime',
        'unlocked_at' => 'datetime',
    ];
}
