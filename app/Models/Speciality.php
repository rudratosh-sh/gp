<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Speciality extends Model
{
    use AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'name',
        'status',
    ];

    /**
     * The attributes for which you can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'status',
        'created_at',
        'updated_at',
    ];
}
