<?php

namespace App\Models;

use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Platform\Models\User as Authenticatable;
use App\Models\Role; // Import the Role model from your application
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'mobile',
        'country_code',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'permissions',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'permissions'          => 'array',
        'email_verified_at'    => 'datetime',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id'         => Where::class,
        'name'       => Like::class,
        'email'      => Like::class,
        'mobile'      => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'email',
        'updated_at',
        'created_at',
        'mobile'
    ];

    public function doctor()
    {
        return $this->hasOne(Doctor::class, 'user_id');
    }

    // Define a many-to-many relationship with your custom Role model
    public function customRoles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function scopeDoctors(Builder $query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'doctor');
        });
    }

    public function medicareDetail()
    {
        return $this->hasOne(MedicareDetail::class, 'user_id');
    }

    public function signupStatus()
    {
        return $this->hasOne(SignupStatus::class, 'user_id');
    }
}
