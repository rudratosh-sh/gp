<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Question;

use App\Models\Question;
use App\Models\Section;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuestionListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'questions';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('section.name', __('Section'))
                ->sort()
                ->filter(Input::make('filter.section_id')),

            TD::make('question_text', __('Question Text'))
                ->sort()
                ->filter(Input::make('filter.question_text')),

            TD::make('order', __('Order'))
                ->sort()
                ->filter(Input::make('filter.order')),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Question $question) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Are you sure you want to delete this question?'))
                        ->method('remove', ['id' => $question->id]);
                }),
        ];
    }
}
