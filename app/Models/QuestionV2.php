<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class QuestionV2 extends Model
{
    use AsSource, Filterable;

    protected $table = 'questions_v2';
    protected $primaryKey = 'question_id';
    protected $fillable = ['quiz_id', 'question_text', 'show_order', 'points', 'question_type_id'];

    public function quiz()
    {
        return $this->belongsTo(QuizV2::class, 'quiz_id');
    }

    public function options()
    {
        return $this->hasMany(OptionV2::class, 'question_id');
    }

    public function answerV2()
    {
        return $this->hasOne(AnswerV2::class, 'question_id');
    }


    public function questionType()
    {
        return $this->belongsTo(QuestionTypeV2::class, 'question_type_id');
    }

}
