<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Question extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'section_id',
        'question_text',
        'order',
        // add other attributes here
    ];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    protected $allowedFilters = [
        'question_text',
        // Add other allowed filters here
    ];

    protected $allowedSorts = [
        'question_text',
        'order'
        // Add other allowed sorts here
    ];

    public $timestamps = true;

    protected static function booted()
    {
        static::saving(function ($question) {
            $maxOrder = static::where('section_id', $question->section_id)->max('order');
            $question->order = max($maxOrder + 1, 0);
        });
    }
}
