<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicQuiz extends Model
{
    protected $table = 'clinic_quiz';
    protected $primaryKey = null; // Since you have a composite primary key
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'quiz_id',
        'clinic_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(QuizV2::class, 'quiz_id');
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
