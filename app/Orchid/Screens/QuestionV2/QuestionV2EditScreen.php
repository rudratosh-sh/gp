<?php

declare(strict_types=1);

namespace App\Orchid\Screens\QuestionV2;

use App\Models\QuestionV2;
use App\Models\QuestionTypeV2;
use App\Orchid\Layouts\QuestionV2\QuestionV2EditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use App\Models\OptionV2;

class QuestionV2EditScreen extends Screen
{
    /**
     * @var QuestionV2
     */
    public $questionV2;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?QuestionV2 $questionV2): array
    {
        $this->questionV2 = $questionV2 ?? new QuestionV2();

        return [
            'questionV2' => $this->questionV2,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->questionV2->exists ? 'Edit Question' : 'Create Question';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->questionV2 && $this->questionV2->exists)
                ? 'platform.systems.questionV2.edit'
                : 'platform.systems.questionV2.create',
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
                ->confirm(__('Once the question is deleted, all related data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->questionV2->exists)
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
        $questionTypes = QuestionTypeV2::pluck('name', 'id')->toArray();

        return [
            Layout::block(QuestionV2EditLayout::class)
                ->title(__('Question Information'))
                ->description(__('Update question details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->questionV2->exists)
                        ->can('platform.systems.questions.edit')
                        ->method('save')
                ),

            Layout::view('vendor.orchid.layouts.components.dynamic-field-container'),
        ];
    }

    /**
     * Save the question data.
     *
     * @param QuestionV2 $questionV2
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(QuestionV2 $questionV2, Request $request)
    {
        $data = $request->validate([
            'questionV2.question_text' => 'required|string|max:255',
            'questionV2.quiz_id' => 'required|exists:quizzes_v2,quiz_id',
            'questionV2.question_type_id' => 'required',
            'questionV2.options' => 'required|array', // Ensure options is an array
            'questionV2.options.*' => 'required|string|max:255',
        ]);

        $questionV2->fill($data['questionV2']);
        $questionV2->save();

        $options = $data['questionV2']['options'];
        $this->saveOptions($questionV2, $options);

        Toast::info(__('Question was saved.'));
        return redirect()->route('platform.systems.questionV2');
    }


    /**
     * Save or update options for the given question.
     *
     * @param QuestionV2 $questionV2
     * @param array $options
     */
    private function saveOptions(QuestionV2 $questionV2, array $options)
    {
        // Delete existing options
        $questionV2->options()->delete();

        // Save new options
        foreach ($options as $optionText) {
            $option = new OptionV2(['option_text' => $optionText]);
            $questionV2->options()->save($option);
        }
    }

    /**
     * Remove the question.
     *
     * @param QuestionV2 $questionV2
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(QuestionV2 $questionV2)
    {
        $questionV2->delete();

        Toast::info(__('Question was removed'));

        return redirect()->route('platform.systems.questions');
    }
}
