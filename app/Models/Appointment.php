<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Prescription;

class Appointment extends Model
{
    protected $fillable = [
        'clinic_id',
        'doctor_id',
        'user_id',
        'appointment_date_time',
        'slot',
        'details',
        'booking_type',
        'last_visited'
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicareDetail()
    {
        return $this->hasOne(MedicareDetail::class, 'user_id', 'user_id');
    }

    public function patientVitalValues()
    {
        return $this->hasMany(PatientVitalsValues::class, 'user_id', 'user_id');
    }

    public function notes()
    {
        return $this->hasOne(Note::class, 'user_id', 'user_id');
    }

    public function otherInfo()
    {
        return $this->hasOne(OtherInfo::class, 'user_id', 'user_id');
    }

    public function refLetter()
    {
        return $this->hasOne(ReferralLetter::class, 'user_id', 'user_id');
    }

    public function prescription()
    {
        return $this->hasOne(PrescriptionV2::class, 'user_id', 'user_id');
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class);
    }
}
