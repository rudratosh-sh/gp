<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Section;

use App\Models\Section;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SectionListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'sections';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('title', __('Title'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Section $section) {
                    return Link::make($section->name)
                        ->route('platform.systems.sections.edit', $section->id)
                        ->icon('bs.pencil');
                }),

            TD::make('questionnaire.name', __('Questionnaire'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Section $section) {
                    return $section->questionnaire->name;
                }),

            TD::make('order', __('Order'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Section $section) {
                    return $section->order;
                }),


            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Section $section) {
                    return $section->updated_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Section $section) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $section->id]);
                }),
        ];
    }
}
