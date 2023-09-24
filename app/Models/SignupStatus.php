<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignupStatus extends Model
{
    protected $table = 'signup_statuses';

    protected $fillable = [
        'user_id',
        'basic_details',
        'otp_verification',
        'medicare_card_verification',
        'card_details_verification',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
