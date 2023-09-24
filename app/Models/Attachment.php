<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;

class Attachment extends Model
{
    // use AsSource, Attachable;

    protected $fillable = [
        'name',
        'original_name',
        'mime',
        'extension',
        'size',
        'sort',
        'path',
        'description',
        'alt',
        'hash',
        'disk',
        'user_id',
        'group',
    ];

    // Other model properties and methods...

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

