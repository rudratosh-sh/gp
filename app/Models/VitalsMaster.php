<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalsMaster extends Model
{
    protected $table = 'vitals_master';

    protected $fillable = [
        'name',
        // Add other fillable fields here
    ];

    // Define relationships
    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_vitals', 'vital_id', 'clinic_id');
    }

    public function patientValues()
    {
        return $this->hasMany(PatientVitalsValues::class, 'clinic_vital_id');
    }
}

