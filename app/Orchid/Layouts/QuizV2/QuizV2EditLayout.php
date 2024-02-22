<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuizV2;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\DateTimer; // Update the import statement for DateTimer
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Format;

class QuizV2EditLayout extends Rows
{
    public $target = 'quiz';

    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('quiz.quiz_name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Quiz Name'))
                ->placeholder(__('Enter Quiz Name')),
        ];
    }
}
