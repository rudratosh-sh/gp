<?php

namespace App\Orchid\Layouts\QuestionV2;

use App\Models\QuizV2;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use Orchid\Support\Facades\Layout;  // Import the Layout facade

class QuestionV2EditLayout extends Rows
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'questionV2';

    /**
     * Views.
     *
     * @return array
     */
    protected function fields(): array
    {
        $questionTypes = [
            '' => 'Select The Question Type',
            1 => 'Range',
            2 => 'Multiple Choice Question',
            3 => 'Multiple Choice Question with multiselect',
            4 => 'Input Answer',
        ];

        $fields = [
            Input::make('questionV2.question_text')
                ->title('Question Text')
                ->placeholder('Enter the Question Text')
                ->required(),

            Select::make('questionV2.quiz_id')
                ->fromModel(QuizV2::class, 'quiz_name', 'quiz_id')
                ->required()
                ->title('Quiz')
                ->placeholder('Select Quiz'),

            Select::make('questionV2.question_type_id')
                ->options($questionTypes)
                ->required()
                ->title('Question Type')
                ->placeholder('Select Question Type')
                ->help('Select the type of question to display additional fields accordingly.'),
        ];

        // Use Layout::view to include the dynamic-field-container view
        // $fields[] = Layout::view('vendor.orchid.layouts.components.dynamic-field-container');

        return $fields;
    }
}
