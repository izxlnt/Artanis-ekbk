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
        'daerah_id',
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

    /**
     * Users belonging to a district. Accepts a daerahs.id (numeric) or a
     * daerah_hutan name, expands it to every daerahs row sharing that
     * daerah_hutan, and matches on users.daerah_id. Users not yet linked to an
     * id (or before the daerah_id migration has run) fall back to matching the
     * users.daerah name, as before.
     */
    public function scopeInDaerah($query, $daerah)
    {
        if ($daerah === null || $daerah === '') {
            return $query->whereRaw('1 = 0');
        }

        $hutan = is_numeric($daerah)
            ? \DB::table('daerahs')->where('id', (int) $daerah)->value('daerah_hutan')
            : $daerah;

        if ($hutan === null) {
            return $query->whereRaw('1 = 0');
        }

        static $hasIdColumn = null;
        if ($hasIdColumn === null) {
            $hasIdColumn = \Illuminate\Support\Facades\Schema::hasColumn('users', 'daerah_id');
        }

        if (!$hasIdColumn) {
            return $query->where('users.daerah', $hutan);
        }

        $ids = \DB::table('daerahs')->where('daerah_hutan', $hutan)->pluck('id')->all();

        return $query->where(function ($q) use ($ids, $hutan) {
            $q->whereIn('users.daerah_id', $ids)
              ->orWhere(function ($q2) use ($hutan) {
                  $q2->whereNull('users.daerah_id')->where('users.daerah', $hutan);
              });
        });
    }

    /**
     * Current daerah_hutan name of the user's district: read from daerahs via
     * daerah_id (so it follows renames), falling back to the stored users.daerah.
     */
    public function getDaerahHutanAttribute()
    {
        if (!empty($this->attributes['daerah_id'])) {
            $name = \DB::table('daerahs')->where('id', $this->attributes['daerah_id'])->value('daerah_hutan');
            if ($name !== null) return $name;
        }
        return $this->attributes['daerah'] ?? null;
    }

    public function getDaerahNumericIdAttribute()
    {
        // Anchored on users.daerah_id; the name lookup is only a fallback for
        // users that have not been linked to a daerahs row yet.
        if (!empty($this->attributes['daerah_id'])) {
            return (int) $this->attributes['daerah_id'];
        }
        if (!$this->daerah) return null;
        static $cache = [];
        if (!array_key_exists($this->daerah, $cache)) {
            $cache[$this->daerah] = \DB::table('daerahs')->where('daerah_hutan', $this->daerah)->value('id');
        }
        return $cache[$this->daerah];
    }

    public function getDaerahIdsAttribute()
    {
        // Access is anchored on users.daerah_id, so a rename of daerahs.daerah_hutan
        // cannot detach the user. It still spans every daerahs row that shares that
        // row's daerah_hutan (e.g. Negeri Sembilan Barat = ids 91-94).
        if (!empty($this->attributes['daerah_id'])) {
            $anchor = (int) $this->attributes['daerah_id'];
            static $idCache = [];
            if (!array_key_exists($anchor, $idCache)) {
                $hutan = \DB::table('daerahs')->where('id', $anchor)->value('daerah_hutan');
                $idCache[$anchor] = $hutan === null
                    ? [$anchor]
                    : \DB::table('daerahs')->where('daerah_hutan', $hutan)->pluck('id')->toArray();
            }
            return $idCache[$anchor];
        }

        if (!$this->daerah) return [];
        static $cache = [];
        if (!array_key_exists($this->daerah, $cache)) {
            $cache[$this->daerah] = \DB::table('daerahs')->where('daerah_hutan', $this->daerah)->pluck('id')->toArray();
        }
        return $cache[$this->daerah];
    }

    public function setLoginIdAttribute($value)
    {
        $this->attributes['login_id'] = implode('/', array_slice(explode('/', trim($value)), 0, 2));
    }

    public function setShuttleTypeAttribute($value)
    {
        $this->attributes['shuttle_type'] = trim($value);
    }

    public function pengguna_kilang()
    {
        return $this->hasOne('App\Models\PenggunaKilang','id','pengguna_kilang_id');
    }

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }

    // SSM-login owner accounts have no pengguna_kilang_id; IC-login sub-users do.
    public function isKilangOwner()
    {
        return is_null($this->pengguna_kilang_id);
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
