<?php

namespace App\Models;

use App\Staff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Filters\Types\WhereDateStartEnd;
use Orchid\Filters\Filterable;

class Clinic extends Model
{
    use HasFactory;
    use Filterable;
    protected $perPage = 15;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'latitude',
        'longitude',
        'status',
        'address',
        'banner_image',
        'profile_icon'
    ];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id'         => Where::class,
        'name'       => Like::class,
        'location'   => Like::class,
        'latitude'   => Where::class,
        'longitude'  => Where::class,
        'status'     => Where::class,
        'address'    => Like::class,
        'updated_at' => WhereDateStartEnd::class,
        'created_at' => WhereDateStartEnd::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'location',
        'latitude',
        'longitude',
        'status',
        'address',
        'updated_at',
        'created_at',
    ];

    /**
     * Get the doctors associated with the clinic.
     */
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Get the staffs associated with the clinic.
     */
    public function staffs()
    {
        return $this->hasMany(Staff::class);
    }

    public function bannerImage()
    {
        return $this->hasOne(Attachment::class, 'id', 'banner_image');
    }

    public function profileIcon()
    {
        return $this->hasOne(Attachment::class, 'id', 'profile_icon');
    }

    /**
     * Get the URL for the clinic's banner image.
     *
     * @return string|null
     */
    public function getBannerImageUrlAttribute()
    {
        if ($this->banner_image) {
            // Assuming 'Attachment' is the model for attachments
            $bannerImage = Attachment::find($this->banner_image); // Get the attachment by ID
            if ($bannerImage) {
                $basePath = 'storage/'; // Define the base path where the images are stored
                return url($basePath . $bannerImage->path . '/' . $bannerImage->name . '.' . $bannerImage->extension);
            }
        }

        return null;
    }

    public function getProfileIconUrlAttribute()
    {
        if ($this->profile_icon) {
            // Assuming 'Attachment' is the model for attachments
            $profileIcon = Attachment::find($this->profile_icon); // Get the attachment by ID
            if ($profileIcon) {
                $basePath = 'storage/'; // Define the base path where the images are stored
                return url($basePath . $profileIcon->path . '/' . $profileIcon->name . '.' . $profileIcon->extension);
            }
        }

        return null;
    }

    public function selectedVitals()
    {
        return $this->hasMany(ClinicVitals::class, 'clinic_id');
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
