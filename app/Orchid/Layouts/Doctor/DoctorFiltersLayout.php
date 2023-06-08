<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Doctor;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class DoctorFiltersLayout extends Rows
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
                ->title('Doctor Name')
                ->placeholder('Filter by Doctor Name'),
                
            Input::make('filter.speciality')
                ->type('text')
                ->title('Speciality')
                ->placeholder('Filter by Speciality'),
                
            Input::make('filter.price')
                ->type('text')
                ->title('Price')
                ->placeholder('Filter by Price'),
                
            Input::make('filter.clinic_name')
                ->type('text')
                ->title('Clinic Name')
                ->placeholder('Filter by Clinic Name'),
                
            // Add more filters as needed
        ];
    }
}
