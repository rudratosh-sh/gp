<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Questionnaire;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Format;

class QuestionnaireEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('questionnaire.format_id')
                ->fromModel(Format::class, 'name', 'id')
                ->required()
                ->title(__('Format'))
                ->placeholder(__('Select Format')),

            Input::make('questionnaire.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Questionnaire Name')),

                Input::make('questionnaire.description')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Description'))
                ->placeholder(__('Questionnaire Description')),

            // Add other fields as needed
        ];
    }
}
