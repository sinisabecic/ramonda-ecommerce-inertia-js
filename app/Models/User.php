<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

    protected $table = 'users';
    protected $guarded = [];
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'owner' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }


    public function photo()
    {
        return $this->morphOne(Photo::class, 'imageable');
    }

    function avatar()
    {
        return env('APP_URL') . '/storage/files/1/Avatars/' . $this->id . '/' . $this->photo->url ?
            env('APP_URL') . '/storage/files/1/Avatars/' . $this->id . '/' . $this->photo->url :
            env('DEFAULT_AVATAR');
    }

    public function getNameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

//    public function setPasswordAttribute($password)
//    {
//        $this->attributes['password'] = Hash::needsRehash($password) ? Hash::make($password) : $password;
//    }


//    public function roles()
//    {
//        return $this->belongsToMany(
//            Role::class,
//            'role_user',
//            'user_id',
//            'role_id')
//            ->withPivot('created_at');
//    }

//    public function role()
//    {
//        foreach (auth()->user()->roles as $role) {
//            return $role;
//        }
//    }

//    public function hasAnyRole($roles)
//    {
//        if (is_array($roles)) {
//            foreach ($roles as $role) {
//                if ($this->hasRole($role)) {
//                    return true;
//                }
//            }
//        } else {
//            if ($this->hasRole($roles)) {
//                return false;
//            }
//        }
//        return false;
//    }
//
//
//    public function hasRole($role_name)
//    {
//        if ($this->roles->where('slug', $role_name)->first()) {
//            return true;
//        }
//        return false;
//    }

    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('Admin'); // or ->role('Admin')->exists(); print: 1/0
    }

    public function scopeOrderByName($query)
    {
        $query->orderBy('last_name')->orderBy('first_name');
    }

    public function scopeWhereRole($query, $role)
    {
        switch ($role) {
            case 'user': return $query->where('owner', false);
            case 'owner': return $query->where('owner', true);
        }
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        })->when($filters['role'] ?? null, function ($query, $role) {
            $query->whereRole($role);
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
