<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserResponse extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'user_id',
        'question_id',
        'selected_option_id',
        'questionnaire_id'
        // add other attributes here
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function selectedOption()
    {
        return $this->belongsTo(AnswerOption::class);
    }

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    protected $allowedFilters = [
        'user_id',
        'question_id',
        'selected_option_id',
        'questionnaire_id'
        // Add other allowed filters here
    ];

    protected $allowedSorts = [
        'user_id',
        'question_id',
        'selected_option_id',
        'questionnaire_id'
        // Add other allowed sorts here
    ];

    public $timestamps = true;
}
