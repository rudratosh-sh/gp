<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Clinic;

use App\Models\Clinic;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ClinicListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'clinics';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => Link::make($clinic->name)
                    ->route('platform.systems.clinics.edit', $clinic->id)
                    ->icon('bs.pencil')),

            TD::make('location', __('Location'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->location),

            TD::make('latitude', __('Latitude'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->latitude),

            TD::make('longitude', __('Longitude'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->longitude),

            TD::make('status', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->status),

            TD::make('address', __('Address'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->address),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(fn (Clinic $clinic) => $clinic->updated_at->toDateTimeString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Clinic $clinic) => Button::make(__('Delete'))
                    ->icon('bs.trash3')
                    ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                    ->method('remove', [
                        'id' => $clinic->id,
                    ])),
        ];

    }
}
