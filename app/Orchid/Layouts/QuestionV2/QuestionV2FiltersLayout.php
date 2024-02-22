<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuestionV2;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class QuestionV2FiltersLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('filter.question_text')
                ->type('text')
                ->title('Question Text')
                ->placeholder('Filter by Question Text'),

            Input::make('filter.quiz_id')
                ->type('text')
                ->title('Quiz ID')
                ->placeholder('Filter by Quiz ID'),

            Input::make('filter.question_type_id')
                ->type('text')
                ->title('Question Type ID')
                ->placeholder('Filter by Question Type ID'),

            // Add more Input::make for other fields if needed
        ];
    }
}
