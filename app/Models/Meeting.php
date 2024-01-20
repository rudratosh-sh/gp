<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'appointment_id',
        'start_time',
        'end_time',
        'notes',
        'transcript',
    ];

    // Define relationships if needed
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}

