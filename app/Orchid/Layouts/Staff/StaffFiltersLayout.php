<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Staff;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class StaffFiltersLayout extends Rows
{
    /**
     * Views.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('filter.name')
                ->type('text')
                ->title('Staff Name')
                ->placeholder('Filter by Staff Name'),

            Input::make('filter.clinic_name')
                ->type('text')
                ->title('Clinic Name')
                ->placeholder('Filter by Clinic Name'),

        ];
    }
}
