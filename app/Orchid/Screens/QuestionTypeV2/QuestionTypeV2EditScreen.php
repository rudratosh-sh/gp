<?php

declare(strict_types=1);

namespace App\Orchid\Screens\questionTypeV2;

use App\Models\questionTypeV2;
use App\Orchid\Layouts\questionTypeV2\questionTypeV2EditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;

class questionTypeV2EditScreen extends Screen
{
    /**
     * @var questionTypeV2
     */
    public $questionTypeV2;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?questionTypeV2 $questionTypeV2): array
    {
        $this->questionTypeV2 = $questionTypeV2 ?? new questionTypeV2();

        return [
            'questionTypeV2' => $this->questionTypeV2,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->questionTypeV2->exists ? 'Edit Question Type' : 'Create Question Type';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->questionTypeV2 && $this->questionTypeV2->exists)
                ? 'platform.systems.questionTypeV2.edit'
                : 'platform.systems.questionTypeV2.create',
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
                ->confirm(__('Once the question type is deleted, all related data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->questionTypeV2->exists)
                ->can('platform.systems.questionTypeV2.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.questionTypeV2.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(questionTypeV2EditLayout::class)
                ->title(__('Question Type Information'))
                ->description(__('Update question type details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->questionTypeV2->exists)
                        ->can('platform.systems.questionTypeV2.edit')
                        ->method('save')
                ),

            // Add more layout elements as needed
        ];
    }

    /**
     * Save the question type data.
     *
     * @param questionTypeV2 $questionType
     * @param Request      $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(questionTypeV2 $questionType, Request $request)
    {
        $data = $request->validate([
            'questionTypeV2.name' => 'required|string|max:255',
        ]);

        $questionType->fill($data['questionTypeV2']);
        $questionType->save();
        Toast::info(__('Question Type was saved.'));

        return redirect()->route('platform.systems.questionTypeV2');
    }

    /**
     * Remove the question type .
     *
     * @param QuestionType $questionType
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(questionTypeV2 $questionType)
    {
        $questionType->delete();

        Toast::info(__('Question Type was removed'));

        return redirect()->route('platform.systems.questionTypeV2');
    }
}
