<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Question;

use App\Models\Question;
use App\Models\Section;
use App\Orchid\Layouts\Question\QuestionEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class QuestionEditScreen extends Screen
{
    /**
     * @var Question
     */
    public $question;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Question $question): array
    {
        $this->question = $question;

        return [
            'question' => $this->question,
            'sections' => Section::orderBy('name')->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->question->exists ? 'Edit Question' : 'Create Question';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update question information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->question && $this->question->exists)
                ? 'platform.systems.questions.edit'
                : 'platform.systems.questions.create',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Remove'))
                ->icon('bs.trash3')
                ->confirm(__('Once the question is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->question->exists)
                ->can('platform.systems.questions.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.questions.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(QuestionEditLayout::class)
                ->title(__('Question Information'))
                ->description(__('Update question details here.')),

            // Add more layouts as needed
        ];
    }

    /**
     * Save the question data.
     *
     * @param Request $request
     * @param Question $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request, Question $question)
    {
        $question->fill($request->get('question'))->save();

        Toast::info(__('Question was saved.'));

        return redirect()->route('platform.systems.questions');
    }

    /**
     * Remove the question.
     *
     * @param Question $question
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Question $question)
    {
        $question->delete();

        Toast::info(__('Question was removed'));

        return redirect()->route('platform.systems.questions');
    }
}
