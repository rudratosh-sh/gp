<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuizV2;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class QuizV2FiltersLayout extends Rows
{
    public $targets = [
        'quiz.clinic_id',
        'quiz.doctor_id',
        'quiz.user_id',
        'quiz',
    ];
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('filter.quiz_name')
                ->type('text')
                ->title('Quiz Name')
                ->placeholder('Filter by Quiz Name'),
        ];
    }
}
