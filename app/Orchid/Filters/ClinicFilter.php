<?php
namespace App\Orchid\Filters;

use Orchid\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Screen\Fields\Input;

class ClinicFilter extends Filter
{

    /**
     * @var array
     */
    public $parameters = ['name'];

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return $builder->where('name', 'like', '%'.$this->request->get('name').'%');
    }

    /**
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Input::make('name')
                ->type('text')
                ->value($this->request->get('name'))
                ->placeholder('Search...')
                ->title('Search')
        ];
    }
}
