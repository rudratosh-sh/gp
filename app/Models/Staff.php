<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clinic_id',
        'user_id',
        'role',
    ];

    /**
     * Get the clinic associated with the doctor.
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * The attributes for which you can use filters in the URL.
     *
     * @var array
     */
    protected $allowedFilters = [
        'name',
        'clinic_id',
    ];

    /**
     * The attributes for which you can use sorting in the URL.
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'clinic_id',
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
