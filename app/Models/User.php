<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Facades\Log;


class User extends Authenticatable implements Auditable
{
    use HasFactory, Notifiable;
    use \OwenIt\Auditing\Auditable;

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'login_id',
        'kategori_pengguna',
        'shuttle_type',
        'is_approved',
        'is_approved_ipjpsm',
        'pengguna_kilang_id',
        'shuttle_id',

        'peranan',
        'status',
        'jawatan',
        'negeri',
        'daerah',
        'bahagian',
        'no_telefon',

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pengguna_kilang()
    {
        return $this->hasOne('App\Models\PenggunaKilang','id','pengguna_kilang_id');
    }

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }

    /**
     * Get the current email for this user from the appropriate table
     * Priority: pengguna_kilang > shuttle > user
     */
    public function getCurrentEmail()
    {
        // For IBK users, prioritize pengguna_kilang email
        if ($this->kategori_pengguna === 'IBK') {
            // Check if there's a pengguna_kilang record with email
            if ($this->pengguna_kilang && !empty($this->pengguna_kilang->email)) {
                return $this->pengguna_kilang->email;
            }
            
            // Check if there's a shuttle record with email
            if ($this->shuttle && !empty($this->shuttle->email)) {
                return $this->shuttle->email;
            }
        }
        
        // For other user types, check pengguna_kilang first
        if ($this->pengguna_kilang && !empty($this->pengguna_kilang->email)) {
            return $this->pengguna_kilang->email;
        }
        
        // Check if there's a shuttle record with email
        if ($this->shuttle && !empty($this->shuttle->email)) {
            return $this->shuttle->email;
        }
        
        // Fall back to user email
        return $this->email;
    }

    /**
     * Get the name for this user from the appropriate table
     * Priority: pengguna_kilang > shuttle > user
     */
    public function getCurrentName()
    {
        // Check if there's a pengguna_kilang record with name
        if ($this->pengguna_kilang && !empty($this->pengguna_kilang->name)) {
            return $this->pengguna_kilang->name;
        }
        
        // Check if there's a shuttle record with name
        if ($this->shuttle && !empty($this->shuttle->name)) {
            return $this->shuttle->name;
        }
        
        // Fall back to user name
        return $this->name;
    }
}
