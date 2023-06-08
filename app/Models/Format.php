<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Format extends Model
{
    use AsSource, Filterable;

    protected $fillable = [
        'name',
        'description',
        // add other attributes here
    ];

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
