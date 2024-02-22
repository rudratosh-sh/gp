<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{
    protected $table = 'user_quiz';
    protected $primaryKey = null; // Since you have a composite primary key
    public $incrementing = false;

    protected $fillable = [
        'quiz_id',
        'user_id',
    ];

    public function quiz()
    {
        return $this->belongsTo(QuizV2::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
