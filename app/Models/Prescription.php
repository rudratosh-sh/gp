<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
        'medication_id',
        'route_id',
        'clinic_id',
        'user_id',
        'doctor_id',
        'quantity',
        'remarks',
        'dosage'
    ];

    public function medication()
    {
        return $this->belongsTo(Medication::class);
    }

    public function route()
    {
        return $this->belongsTo(Route::class);
    }
}

