<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuestionV2;

use App\Models\QuestionV2;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

class QuestionV2ListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'questionV2';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('question_id', 'ID'),

            TD::make('questionV2.question_text', __('Question Text'))
                ->render(function (QuestionV2 $question) {
                    return Link::make($question->question_text)
                        ->route('platform.systems.questionV2.edit', $question->question_id)
                        ->icon('bs.pencil');
                }),

            TD::make('questionV2.quiz_id', __('Quiz'))
                ->render(function (QuestionV2 $question) {
                    return $question->quiz->quiz_name;
                }),

            TD::make('questionV2.question_type_id', __('Question Type'))
                ->render(function (QuestionV2 $question) {
                    return $question->questionType->name;
                }),

            TD::make('questionV2.options.*', __('Options'))
                ->render(function (QuestionV2 $question) {
                    return implode(', ', $question->options->pluck('option_text')->toArray());
                }),

            TD::make('questionV2.answerV2.answer_text', __('Answer'))
                ->render(function (QuestionV2 $question) {
                    return $question->answerV2 ? $question->answerV2->answer_text : '';
                }),


            // Add more TD::make for other fields if needed

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (QuestionV2 $question) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $question->question_id]);
                }),
        ];
    }
}
