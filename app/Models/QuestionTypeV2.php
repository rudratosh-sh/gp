<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class QuestionTypeV2 extends Model
{
    use AsSource, Filterable;

    public $timestamps = false;

    protected $table = 'question_types'; // Update to the actual table name
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function questions()
    {
        return $this->hasMany(QuestionV2::class, 'question_type_id');
    }

    protected $allowedFilters = [
        'name',
    ];

    protected $allowedSorts = [
        'name',
    ];
}
