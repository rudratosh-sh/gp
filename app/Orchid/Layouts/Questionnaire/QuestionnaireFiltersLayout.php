<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Questionnaire;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class QuestionnaireFiltersLayout extends Rows
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
                ->title('Questionnaire Name')
                ->placeholder('Filter by Questionnaire Name'),
                
            // Add more filters as needed
        ];
    }
}
