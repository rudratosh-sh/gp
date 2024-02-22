<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\QuestionTypeV2;

use App\Models\QuestionTypeV2;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;

class QuestionTypeV2EditLayout extends Rows
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'questionTypeV2';


    /**
     * Views.
     *
     * @return Field[]
     */
    protected function fields(): array
    {
        return [
            Input::make('questionTypeV2.name')
                ->title('Name')
                ->placeholder('Enter the Name')
                ->required(),
            Select::make('questionnaire.format_id')
                ->fromModel(QuestionTypeV2::class, 'name', 'id')
                ->required()
                ->title(__('Format'))
                ->placeholder(__('Select Format')),
        ];
    }
}
