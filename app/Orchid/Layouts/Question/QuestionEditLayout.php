<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Question;

use App\Models\Question;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Section;
use Orchid\Screen\Fields\Label;


class QuestionEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @param Question|null $question
     *
     * @return Field[]
     */
    public function fields(Question $question = null): array
    {
        $sections = Section::pluck('name', 'id')->toArray();

        return [
            Select::make('question.section_id')
                ->options($sections)
                ->required()
                ->title(__('Section'))
                ->placeholder(__('Select Section'))
                ->value($question->section_id ?? null),

            Input::make('question.question_text')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Question Text'))
                ->placeholder(__('Enter the question text'))
                ->value($question->question_text ?? null),

                Label::make('section.order')
                ->title(__('Order'))
                ->readonly()
                ->value(function () use ($question) {
                    return $question ? $question->order : '';
                }),
            
            // Add other fields as needed
        ];
    }
}
