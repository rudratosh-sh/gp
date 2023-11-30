<?php
// Appointment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'clinic_id',
        'doctor_id',
        'user_id',
        'appointment_date_time',
        'slot',
        'details',
        'booking_type'
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
}
