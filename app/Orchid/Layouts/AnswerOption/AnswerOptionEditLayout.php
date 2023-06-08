<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\AnswerOption;

use App\Models\Question;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;

class AnswerOptionEditLayout extends Rows
{
    /**
     * Views.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Relation::make('answeroptions.question_id')
                ->title('Question')
                ->fromModel(Question::class, 'question_text'),

            Input::make('answeroptions.option_text')
                ->title('Option Text')
                ->placeholder('Enter the option text')
                ->required(),

            Input::make('answeroptions.score')
                ->title('Score')
                ->type('number')
                ->placeholder('Enter the option score'),

            Input::make('answeroptions.order')
                ->title('Order')
                ->type('number')
                ->placeholder('Enter the option order'),

            TextArea::make('answeroptions.description')
                ->title('Description')
                ->rows(3)
                ->placeholder('Enter the option description'),
        ];
    }
}
