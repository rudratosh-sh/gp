<?php

declare(strict_types=1);

namespace App\Orchid\Screens\QuizV2;

use App\Models\QuizV2;
use App\Orchid\Layouts\QuizV2\QuizV2EditLayout;
use App\Orchid\Layouts\QuizV2\QuizV2FiltersLayout;
use App\Orchid\Layouts\QuizV2\QuizV2ListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class QuizV2ListScreen extends Screen
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
            'quizzes' => QuizV2::defaultSort('quiz_id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Quiz Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all quizzes.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.quizV2.view',
            'platform.systems.quizV2.create',
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
                ->route('platform.systems.quizV2.create')
                ->canSee($this->hasPermission('platform.systems.quizV2.create')),
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
            QuizV2FiltersLayout::class,
            QuizV2ListLayout::class,

            Layout::modal('asyncEditQuizModal', QuizV2EditLayout::class)
                ->async('asyncGetQuiz'),
        ];
    }

    /**
     * Fetch quiz data asynchronously for editing.
     *
     * @param QuizV2 $quiz
     *
     * @return array
     */
    public function asyncGetQuiz(QuizV2 $quiz): array
    {
        return [
            'quiz' => $quiz,
        ];
    }

    /**
     * Save the quiz data.
     *
     * @param Request $request
     * @param QuizV2  $quiz
     */
    public function saveQuiz(Request $request, QuizV2 $quiz): void
    {
        $quiz->fill($request->input('quiz'))->save();

        Toast::info(__('Quiz was saved.'));
    }

    /**
     * Remove the quiz.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        QuizV2::findOrFail($request->get('id'))->delete();

        Toast::info(__('Quiz was removed'));
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
