<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Section extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'questionnaire_id',
        'name',
        'order'
        // add other attributes here
    ];

    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class);
    }

    protected $allowedFilters = [
        'name',
        'order'
        // Add other allowed filters here
    ];

    protected $allowedSorts = [
        'name',
        'order'
        // Add other allowed sorts here
    ];

    public $timestamps = true;

    protected static function booted()
    {
        static::saving(function ($section) {
            $maxOrder = static::where('questionnaire_id', $section->questionnaire_id)->max('order');
            $section->order = max($maxOrder + 1, 0);
        });
    }

}
