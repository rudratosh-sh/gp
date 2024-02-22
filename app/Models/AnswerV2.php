<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnswerV2 extends Model
{
    protected $table = 'answers_v2';
    protected $primaryKey = 'answer_id';
    protected $fillable = ['question_id', 'answer_text', 'min_value', 'max_value'];

    public function question()
    {
        return $this->belongsTo(QuestionV2::class, 'question_id');
    }
}
