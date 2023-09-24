<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    // Define the relationship with the 'users' table
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Define the relationship with the 'roles' table
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
