<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Questionnaire;

use App\Models\Questionnaire;
use App\Orchid\Layouts\Questionnaire\QuestionnaireEditLayout;
use App\Orchid\Layouts\Questionnaire\QuestionnaireFiltersLayout;
use App\Orchid\Layouts\Questionnaire\QuestionnaireListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuestionnaireListScreen extends Screen
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
            'questionnaires' => Questionnaire::defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Questionnaire Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all questionnaires.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.questionnaires.view',
            'platform.systems.questionnaires.create',
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
                ->route('platform.systems.questionnaires.create')
                ->canSee($this->hasPermission('platform.systems.questionnaires.create')),
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
            QuestionnaireFiltersLayout::class,
            QuestionnaireListLayout::class,

            Layout::modal('asyncEditQuestionnaireModal', QuestionnaireEditLayout::class)
                ->async('asyncGetQuestionnaire'),
        ];
    }

    /**
     * Fetch questionnaire data asynchronously for editing.
     *
     * @param Questionnaire $questionnaire
     *
     * @return array
     */
    public function asyncGetQuestionnaire(Questionnaire $questionnaire): array
    {
        return [
            'questionnaire' => $questionnaire,
        ];
    }

    /**
     * Save the questionnaire data.
     *
     * @param Request      $request
     * @param Questionnaire $questionnaire
     */
    public function saveQuestionnaire(Request $request, Questionnaire $questionnaire): void
    {
        $questionnaire->fill($request->input('questionnaire'))->save();

        Toast::info(__('Questionnaire was saved.'));
    }

    /**
     * Remove the questionnaire.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Questionnaire::findOrFail($request->get('id'))->delete();

        Toast::info(__('Questionnaire was removed'));
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
