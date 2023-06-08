<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Format;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use App\Models\Format;

class FormatEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('format.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Format Name')),

            Input::make('format.description')
                ->type('textarea')
                ->required()
                ->title(__('Description'))
                ->placeholder(__('Format Description')),

            // Add other fields as needed based on the columns of your format table
        ];
    }
}
