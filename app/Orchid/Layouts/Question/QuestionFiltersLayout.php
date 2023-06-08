<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Question;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Section;

class QuestionFiltersLayout extends Rows
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
                ->title(__('Question Text'))
                ->placeholder(__('Filter by Question Text'))
                ->async('filterQuestions'),

            Select::make('filter.section_id')
                ->fromModel(Section::class, 'name')
                ->title(__('Section'))
                ->placeholder(__('Filter by Section'))
                ->async('filterQuestions'),

            // Add more filters as needed
        ];
    }
}
