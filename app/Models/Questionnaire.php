<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Questionnaire extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'format_id',
        'name',
        'description'
        // add other attributes here
    ];

    public function format()
    {
        return $this->belongsTo(Format::class);
    }

    protected $allowedFilters = [
        'name',
        // Add other allowed filters here
    ];

    protected $allowedSorts = [
        'name',
        // Add other allowed sorts here
    ];

    public $timestamps = true;
}
