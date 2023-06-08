<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Format;

use App\Models\Format;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class FormatListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'formats';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Format $format) {
                    return Link::make($format->name)
                        ->route('platform.systems.formats.edit', $format->id)
                        ->icon('bs.pencil');
                }),

            TD::make('description', __('Description'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Format $format) {
                    return $format->description;
                }),

            TD::make('created_at', __('Created At'))
                ->sort()
                ->render(function (Format $format) {
                    return $format->created_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Format $format) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $format->id]);
                }),
        ];
    }
}
