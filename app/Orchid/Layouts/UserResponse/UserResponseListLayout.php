<?php

namespace App\Orchid\Layouts\UserResponse;

use App\Models\UserResponse;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class UserResponseListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    protected $target = 'userResponses';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): array
    {
        return [
            TD::make('id', 'ID'),

            TD::make('user.name', 'User')
                ->render(function (UserResponse $userResponse) {
                    return Link::make($userResponse->user->name)
                        ->route('platform.systems.users.edit', $userResponse->user);
                }),

            TD::make('question.question_text', 'Question')
                ->render(function (UserResponse $userResponse) {
                    return Link::make($userResponse->question->question_text)
                        ->route('platform.systems.questions.edit', $userResponse->question);
                }),

            TD::make('selectedOption.option_text', 'Selected Option')
                ->render(function (UserResponse $userResponse) {
                    return Link::make($userResponse->selectedOption->option_text)
                        ->route('platform.systems.answerOptions.edit', $userResponse->selectedOption);
                }),

            TD::make('questionnaire.name', 'Questionnaire')
                ->render(function (UserResponse $userResponse) {
                    return Link::make($userResponse->questionnaire->name)
                        ->route('platform.systems.questionnaires.edit', $userResponse->questionnaire);
                }),

            TD::make('timestamp', 'Timestamp'),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (UserResponse $userResponse) {
                    // Add your action buttons here
                }),
        ];
    }
}
