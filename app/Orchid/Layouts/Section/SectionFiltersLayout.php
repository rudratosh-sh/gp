<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Section;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class SectionFiltersLayout extends Rows
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
                ->title('Section Title')
                ->placeholder('Filter by Section Title'),
                
            // Add more filters as needed
        ];
    }
}
