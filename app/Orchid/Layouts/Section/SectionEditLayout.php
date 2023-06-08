<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Section;

use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Label;
use Orchid\Screen\Layouts\Rows;
use App\Models\Section;
use App\Models\Questionnaire;


class SectionEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @param Section|null $section
     *
     * @return \Orchid\Screen\Field[]
     */
    public function fields(Section $section = null): array
    {
        return [

            Select::make('section.questionnaire_id')
            ->fromModel(Questionnaire::class, 'name')
            ->required()
            ->title(__('Questionnaire'))
            ->placeholder(__('Select Questionnaire')),


            Input::make('section.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Title'))
                ->placeholder(__('Section Title')),
            
            // ...
            
            Label::make('section.order')
                ->title(__('Order'))
                ->readonly()
                ->value(function () use ($section) {
                    return $section ? $section->order : '';
                }),
            
            // ...
        ];
    }
}
