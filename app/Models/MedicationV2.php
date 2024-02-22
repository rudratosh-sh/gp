<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationV2 extends Model
{
    protected $table = 'medicationV2';
    protected $fillable = ['drug_name', 'dosage', 'route', 'updated_on', 'created_on'];
    public $timestamps = false; // Assuming 'updated_on' and 'created_on' are managed by MySQL timestamps

    public function prescriptions()
    {
        return $this->hasMany(PrescriptionV2::class, 'medication_id');
    }
}
