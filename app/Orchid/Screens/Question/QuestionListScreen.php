<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Question;

use App\Models\Question;
use App\Models\Section;
use App\Orchid\Layouts\Question\QuestionFiltersLayout;
use App\Orchid\Layouts\Question\QuestionListLayout;
use App\Orchid\Layouts\Question\QuestionEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuestionListScreen extends Screen
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
            'questions' => Question::with('section')->defaultSort('id', 'desc')->paginate(),
            'sections' => Section::orderBy('name')->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Question Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all questions.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.questions.view',
            'platform.systems.questions.create',
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
                ->route('platform.systems.questions.create')
                ->canSee($this->hasPermission('platform.systems.questions.create')),
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
            QuestionFiltersLayout::class,
            QuestionListLayout::class,

            Layout::modal('asyncEditQuestionModal', QuestionEditLayout::class)
                ->async('asyncGetQuestion'),
        ];
    }

    /**
     * Fetch question data asynchronously for editing.
     *
     * @param Question $question
     *
     * @return array
     */
    public function asyncGetQuestion(Question $question): array
    {
        return [
            'question' => $question,
        ];
    }

    /**
     * Save the question data.
     *
     * @param Request $request
     * @param Question $question
     */
    public function saveQuestion(Request $request, Question $question): void
    {
        $question->fill($request->input('question'))->save();

        Toast::info(__('Question was saved.'));
    }

    /**
     * Remove the question.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Question::findOrFail($request->get('id'))->delete();

        Toast::info(__('Question was removed'));
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
