<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\AnswerOption;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class AnswerOptionFiltersLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('filter.option_text')
                ->type('text')
                ->title('Option Text')
                ->placeholder('Filter by Option Text'),

            Input::make('filter.question_id')
                ->type('text')
                ->title('Question ID')
                ->placeholder('Filter by Question ID'),

            // Add more filters as needed
        ];
    }
}
