<?php

declare(strict_types=1);

namespace App\Orchid\Screens\AnswerOption;

use App\Models\AnswerOption;
use App\Orchid\Layouts\AnswerOption\AnswerOptionListLayout;
use App\Orchid\Layouts\AnswerOption\AnswerOptionFiltersLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class AnswerOptionListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Request $request
     *
     * @return array
     */
    public function query(Request $request): array
    {
        return [
            'answerOptions' => AnswerOption::defaultSort('id', 'desc')->get(),
        ];
    }
        /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Answer Option Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all answer options.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.answerOptions.view',
            'platform.systems.answerOptions.create',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.answerOptions.create')
                ->canSee($this->hasPermission('platform.systems.answerOptions.create')),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            AnswerOptionFiltersLayout::class,
            AnswerOptionListLayout::class,
        ];
    }

    /**
     * Save the answer option data.
     *
     * @param Request      $request
     * @param AnswerOption $answerOption
     */
    public function save(Request $request, AnswerOption $answerOption): void
    {
        $answerOption->fill($request->input('answerOption'))->save();

        Toast::info(__('Answer option was saved.'));
    }

    /**
     * Remove the answer option.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        AnswerOption::findOrFail($request->get('id'))->delete();

        Toast::info(__('Answer option was removed'));
    }

    /**
     * Check if a specific permission exists for this screen.
     *
     * @param string $permission
     *
     * @return bool
     */
    private function hasPermission(string $permission): bool
    {
        return collect($this->permission())->contains($permission);
    }
}
