<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\AnswerOption;

use App\Models\AnswerOption;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class AnswerOptionListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'answerOptions';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [

            TD::make('question_text', __('Question'))
                ->render(function (AnswerOption $answerOption) {
                    return Link::make($answerOption->question->question_text)
                        ->route('platform.systems.questions.edit', $answerOption->question);
                }),

            TD::make('option_text', __('Option Text'))
                ->render(function (AnswerOption $answerOption) {
                    return Link::make($answerOption->option_text)
                        ->route('platform.systems.answerOptions.edit', $answerOption);
                }),

            TD::make('score', __('Score'))
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('order', __('Order'))
                ->sort()
                ->filter(TD::FILTER_TEXT),

            TD::make('description', __('Description'))
                ->render(function (AnswerOption $answerOption) {
                    return $answerOption->description ?? '-';
                }),

        ];
    }
}
