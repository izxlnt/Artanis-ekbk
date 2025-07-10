<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audits';

    protected $fillable = [
        'user_type', 'user_id', 'event', 'old_values', 'new_values', 'url', 'ip_address', 'user_agent', 'tags', 'auditable_type', 'auditable_id'
    ];

    protected $dates = ['created_at','updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
