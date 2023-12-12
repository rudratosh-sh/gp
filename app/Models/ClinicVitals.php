<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicVitals extends Model
{
    protected $table = 'clinic_vitals';

    protected $fillable = [
        'clinic_id',
        'vital_id',
        // Add other fillable fields here
    ];

    // Define relationships
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function vital()
    {
        return $this->belongsTo(VitalsMaster::class);
    }

    public function patientValues()
    {
        return $this->hasMany(PatientVitalsValues::class, 'clinic_vital_id');
    }
}
