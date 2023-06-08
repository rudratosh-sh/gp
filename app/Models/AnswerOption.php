<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnswerOption extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'question_id',
        'option_text',
        'score',
        'order'
        // add other attributes here
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    protected $allowedFilters = [
        'option_text',
        'question_id'
        // Add other allowed filters here
    ];

    protected $allowedSorts = [
        'option_text',
        'order',
        'question_id'
        // Add other allowed sorts here
    ];

    public $timestamps = true;
}
