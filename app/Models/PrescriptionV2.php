<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionV2 extends Model
{
    protected $table = 'prescriptionV2';
    protected $fillable = ['medication_id', 'clinic_id', 'doctor_id', 'user_id', 'quantity', 'remarks', 'created_at', 'updated_at'];

    public function medication()
    {
        return $this->belongsTo(MedicationV2::class, 'medication_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id','user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
