<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherInfo extends Model
{
    use HasFactory;
    protected $table = 'other_info';

    protected $fillable = [
        'date',
        'presenting_complaints',
        'relevant_history',
        'examination',
        'recommendation',
        'followup',
        'personalization_framework',
        'user_id',
        'clinic_id',
        'doctor_id',
        'attachments'
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

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'user_id', 'user_id');
    }
}
