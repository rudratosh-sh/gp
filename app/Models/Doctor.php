<?php

namespace App\Models;

use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use AsSource, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'clinic_id',
        'speciality_id',
        'price',
        'doctor_id',
        'user_id'
    ];

    /**
     * Get the clinic associated with the doctor.
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * Get the speciality associated with the doctor.
     */
    public function speciality()
    {
        return $this->belongsTo(Speciality::class);
    }

    // Add other relationships, accessors, mutators, or methods as needed

    /**
     * The attributes for which you can use filters in the URL.
     *
     * @var array
     */
    protected $allowedFilters = [
        'name',
        'clinic_id',
        'speciality_id',
        'price',
        // Add other allowed filters here
    ];

    /**
     * The attributes for which you can use sorting in the URL.
     *
     * @var array
     */
    protected $allowedSorts = [
        'name',
        'clinic_id',
        'speciality_id',
        'price',
        // Add other allowed sorts here
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

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function referralLetters()
    {
        return $this->hasMany(ReferralLetter::class);
    }
}
