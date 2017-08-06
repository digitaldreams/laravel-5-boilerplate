<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * User Roles
     *
     * @return BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role');
    }

    /**
     * Whether the user has the specified role or not.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return (bool)$this->roles()->where('slug', $role)->count();
    }

    /**
     * Checking user is System Administrator or not
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole(Role::SLUG_ADMIN);
    }
}
