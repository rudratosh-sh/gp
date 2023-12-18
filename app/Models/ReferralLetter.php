<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferralLetter extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'clinic_id',
        'doctor_id',
        'attachments', // Consider using a JSON column or another method to store multiple attachment IDs
        'subject',
        'content',
        'refer_to'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

}
