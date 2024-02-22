<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionV2 extends Model
{
    protected $table = 'options_v2';
    protected $primaryKey = 'option_id';
    protected $fillable = ['question_id', 'option_text', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(QuestionV2::class, 'question_id');
    }
}
