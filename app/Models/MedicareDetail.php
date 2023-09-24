<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicareDetail extends Model
{
    protected $table = 'medicare_details';

    protected $fillable = [
        'user_id',
        'medicare_number',
        'gender',
        'birthdate',
        'medicare_image',
        'address',
        // Add other fillable fields here
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
