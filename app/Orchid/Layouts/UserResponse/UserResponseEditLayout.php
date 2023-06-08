<?php

namespace App\Orchid\Layouts\UserResponse;

use App\Models\UserResponse;
use App\Models\Question;
use App\Models\AnswerOption;
use App\Models\Questionnaire;
use App\Models\User;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;

class UserResponseEditLayout extends Rows
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'user_responses';

    /**
     * Get the fields to be displayed.
     *
     * @return array
     */
    protected function fields(): array
    {
        return [
            Select::make('userResponse.user_id')
                ->fromModel(User::class, 'name')
                ->required()
                ->title('User')
                ->placeholder('Select User')
                ->displayUsingLabels(),

            Select::make('userResponse.question_id')
                ->fromModel(Question::class, 'question_text')
                ->required()
                ->title('Question')
                ->placeholder('Select Question')
                ->displayUsingLabels(),

            Select::make('userResponse.selected_option_id')
                ->fromModel(AnswerOption::class, 'option_text')
                ->required()
                ->title('Selected Option')
                ->placeholder('Select Selected Option')
                ->displayUsingLabels(),

            Select::make('userResponse.questionnaire_id')
                ->fromModel(Questionnaire::class, 'name')
                ->required()
                ->title('Questionnaire')
                ->placeholder('Select Questionnaire')
                ->displayUsingLabels(),
            
            // Add other fields here
        ];
    }
}
