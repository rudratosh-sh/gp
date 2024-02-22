<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuizV2;

use App\Models\QuizV2;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuizV2ListLayout extends Table
{
    /**
     * @var string

     */
    public $target = 'quizzes';

    /**
     * @return TD[]
     */
    protected function columns(): array
{
    return [
        TD::make('quiz_id', 'ID'),
        TD::make('quiz_name', __('Quiz Name')) // Use the actual column name from your database
            ->render(function (QuizV2 $quizV2) {
                return Link::make($quizV2->quiz_name) // Use the actual column name from your database
                    ->route('platform.systems.quizV2.edit', $quizV2->quiz_id)
                    ->icon('bs.pencil');
            }),

        TD::make(__('Actions'))
            ->align(TD::ALIGN_CENTER)
            ->width('100px')
            ->render(function (QuizV2 $quizV2) {
                return Button::make(__('Delete'))
                    ->icon('bs.trash3')
                    ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                    ->method('remove', ['quizV2' => $quizV2->quiz_id]);
            }),
    ];
}

}
