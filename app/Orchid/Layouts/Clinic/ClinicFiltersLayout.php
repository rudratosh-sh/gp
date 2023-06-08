<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Clinic;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class ClinicFiltersLayout extends Rows
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
                ->title('Clinic Name')
                ->placeholder('Filter by Clinic Name'),
                
            // Add more filters as needed
        ];
    }
}
