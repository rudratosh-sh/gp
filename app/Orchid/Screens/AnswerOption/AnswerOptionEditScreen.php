<?php

declare(strict_types=1);

namespace App\Orchid\Screens\AnswerOption;

use App\Models\AnswerOption;
use App\Orchid\Layouts\AnswerOption\AnswerOptionEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;

class AnswerOptionEditScreen extends Screen
{
    /**
     * @var AnswerOption
     */
    public $answerOption;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?AnswerOption $answerOption): array
    {
        $this->answerOption = $answerOption ?? new AnswerOption();

        return [
            'answerOption' => $this->answerOption,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->answerOption->exists ? 'Edit Answer Option' : 'Create Answer Option';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update answer option information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->answerOption && $this->answerOption->exists)
                ? 'platform.systems.answerOptions.edit'
                : 'platform.systems.answerOptions.create',
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
                ->confirm(__('Once the answer option is deleted, all related data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->answerOption->exists)
                ->can('platform.systems.answerOptions.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.answerOptions.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(AnswerOptionEditLayout::class)
                ->title(__('Answer Option Information'))
                ->description(__('Update answer option details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->answerOption->exists)
                        ->can('platform.systems.answerOptions.edit')
                        ->method('save')
                ),

            // Add more layout elements as needed
        ];
    }

    /**
     * Save the answer option data.
     *
     * @param AnswerOption $answerOption
     * @param Request      $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(AnswerOption $answerOption, Request $request)
    {
        $answerOption->fill($request->get('answeroptions'));

        // Save the answer option
        $answerOption->save();

        Toast::info(__('Answer option was saved.'));

        return redirect()->route('platform.systems.answerOptions');
    }

    /**
     * Remove the answer option.
     *
     * @param AnswerOption $answerOption
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(AnswerOption $answerOption)
    {
        $answerOption->delete();

        Toast::info(__('Answer option was removed'));

        return redirect()->route('platform.systems.answerOptions');
    }
}
