<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientVitalsValues extends Model
{
    protected $table = 'patient_vitals_values';

    protected $fillable = [
        'clinic_vital_id',
        'user_id',
        'value',
    ];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clinicVital()
    {
        return $this->belongsTo(ClinicVitals::class, 'clinic_vital_id');
    }
}
