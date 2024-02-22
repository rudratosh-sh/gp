<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuestionTypeV2;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class QuestionTypeV2FiltersLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('filter.name')
                ->type('text')
                ->title('Name')
                ->placeholder('Filter by Name'),

            Input::make('filter.id')
                ->type('text')
                ->title('Question Type ID')
                ->placeholder('Filter by Question Type ID'),
        ];
    }
}
