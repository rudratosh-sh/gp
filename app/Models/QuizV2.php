<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class QuizV2 extends Model
{
    use AsSource, Filterable;

    protected $table = 'quizzes_v2';
    protected $primaryKey = 'quiz_id';
    protected $fillable = ['quiz_id','quiz_name', 'start_time', 'end_time'];
    public $timestamps = false;

    public function questions()
    {
        return $this->hasMany(QuestionV2::class, 'quiz_id');
    }

    public function clinicQuizzes()
    {
        return $this->hasMany(ClinicQuiz::class, 'quiz_id');
    }

    public function doctorQuizzes()
    {
        return $this->hasMany(DoctorQuiz::class, 'quiz_id');
    }

    public function userQuizzes()
    {
        return $this->hasMany(UserQuiz::class, 'quiz_id');
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_quiz', 'quiz_id', 'doctor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_quiz', 'quiz_id','user_id');
    }


    protected $allowedFilters = [
        'quiz_name',
    ];

    protected $allowedSorts = [
        'quiz_name',
    ];
}
