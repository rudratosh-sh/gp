<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Format;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;

class FormatFiltersLayout extends Rows
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
                ->title('Format Name')
                ->placeholder('Filter by Format Name'),

            // Add more filters as needed
        ];
    }
}
