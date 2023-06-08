<?php

namespace App\Orchid\Layouts\UserResponse;

use Orchid\Screen\Actions\Button;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;


class UserResponseFiltersLayout extends Rows
{
    /**
     * Get the filters for the layout.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            Input::make('user_id')
                ->title('User ID'),

            Input::make('question_id')
                ->title('Question ID'),

            Input::make('selected_option_id')
                ->title('Selected Option ID'),

            Input::make('questionnaire_id')
                ->title('Questionnaire ID'),
            
            // Add other filters here
        ];
    }

    /**
     * Get the actions for the layout.
     *
     * @return array
     */
    public function actions(): array
    {
        return [
            Button::make('Reset Filters')
                ->method('resetFilters')
                ->type(Color::BASIC),
            // Add other actions here
        ];
    }
}
