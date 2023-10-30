<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    const SUPER_ADMIN_ROLE_ID = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'login',
        'password',
        'role_id'
    ];

    const ROLE_CLIENT = 'client';
    const ROLE_STORE = 'store';

    public function role(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

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
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function ScopefindClient($query, $id) {
      return $query->whereHas('roles', function ($query) {
            $query->where('name', 'client');
        })->where('id', $id);
    }

    public function ScopefindProvider($query, $id) {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'provider');
        })->where('id', $id);
    }

    public function ScopefindStore($query, $id) {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'store');
        })->where('id', $id);
    }

    public function stores() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'stores_users', 'user_id', 'store_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'store');
            });
    }
    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'stores_users', 'user_id', 'store_id')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            });
    }

}
