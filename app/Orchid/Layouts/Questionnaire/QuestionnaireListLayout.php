<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Questionnaire;

use App\Models\Questionnaire;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class QuestionnaireListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'questionnaires';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('title', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Questionnaire $questionnaire) {
                    return Link::make($questionnaire->name)
                        ->route('platform.systems.questionnaires.edit', $questionnaire->id)
                        ->icon('bs.pencil');
                }),

                TD::make('title', __('Description'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Questionnaire $questionnaire) {
                    return $questionnaire->description;
                }),

            TD::make('format.name', __('Format'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Questionnaire $questionnaire) {
                    return $questionnaire->format->name;
                }),

            TD::make('updated_at', __('Last Edit'))
                ->sort()
                ->render(function (Questionnaire $questionnaire) {
                    return $questionnaire->updated_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Questionnaire $questionnaire) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $questionnaire->id]);
                }),
        ];
    }
}
