<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuestionTypeV2;

use App\Models\QuestionTypeV2;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Button;

class QuestionTypeV2ListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'questionTypeV2';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),
            TD::make('title', __('Name'))
            ->render(function (QuestionTypeV2 $QuestionTypeV2) {
                return Link::make($QuestionTypeV2->name)
                    ->route('platform.systems.questionTypeV2.edit', $QuestionTypeV2->id)
                    ->icon('bs.pencil');
            }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (QuestionTypeV2 $QuestionTypeV2) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $QuestionTypeV2->id]);
                }),
        ];
    }
}
