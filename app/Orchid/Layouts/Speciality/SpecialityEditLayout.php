<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Speciality;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Speciality;

class SpecialityEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('speciality.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Speciality Name')),

            Select::make('speciality.status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ])
                ->required()
                ->title(__('Status'))
                ->placeholder(__('Select Status')),
        ];
    }
}
