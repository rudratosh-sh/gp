<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Clinic;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Rows;

class ClinicEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('clinic.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Clinic Name')),

            Input::make('clinic.location')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Location'))
                ->placeholder(__('Clinic Location')),

            Input::make('clinic.latitude')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Latitude'))
                ->placeholder(__('Clinic Latitude')),

            Input::make('clinic.longitude')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Longitude'))
                ->placeholder(__('Clinic Longitude')),

            Input::make('clinic.address')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Address'))
                ->placeholder(__('Clinic Address')),

            CheckBox::make('clinic.status')
                ->sendTrueOrFalse()
                ->value(1)
                ->title(__('Status'))
                ->placeholder(__('Clinic Status')),
        ];
    }
}
