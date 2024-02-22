<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorQuiz extends Model
{
    protected $table = 'doctor_quiz';
    protected $primaryKey = null; // Since you have a composite primary key
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'doctor_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(QuizV2::class, 'quiz_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'user_id');
    }
}
