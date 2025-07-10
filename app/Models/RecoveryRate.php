<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'shuttle_type',
        'min_recovery_rate',
        'max_recovery_rate',
    ];
}
