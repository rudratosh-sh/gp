<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Questionnaire;

use App\Models\Questionnaire;
use App\Orchid\Layouts\Questionnaire\QuestionnaireEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class QuestionnaireEditScreen extends Screen
{
    /**
     * @var Questionnaire
     */
    public $questionnaire;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Questionnaire $questionnaire): array
    {
        $this->questionnaire = $questionnaire ?? new Questionnaire();

        return [
            'questionnaire' => $this->questionnaire,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->questionnaire->exists ? 'Edit Questionnaire' : 'Create Questionnaire';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update questionnaire information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->questionnaire && $this->questionnaire->exists)
                ? 'platform.systems.questionnaires.edit'
                : 'platform.systems.questionnaires.create',
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
                ->confirm(__('Once the questionnaire is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->questionnaire->exists)
                ->can('platform.systems.questionnaires.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.questionnaires.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(QuestionnaireEditLayout::class)
                ->title(__('Questionnaire Information'))
                ->description(__('Update questionnaire details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->questionnaire->exists)
                        ->can('platform.systems.questionnaires.edit')
                        ->method('save')
                ),
        ];
    }

    /**
     * Save the questionnaire data.
     *
     * @param Questionnaire $questionnaire
     * @param Request       $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Questionnaire $questionnaire, Request $request)
    {
        $data = $request->validate([
            'questionnaire.name' => 'required|string|max:255',
            'questionnaire.format_id' => 'required',
            'questionnaire.description' => 'required',
        ]);

        $questionnaire->fill($data['questionnaire']);
        $questionnaire->save();
        Toast::info(__('Questionnaire was saved.'));

        return redirect()->route('platform.systems.questionnaires');
    }

    /**
     * Remove the questionnaire.
     *
     * @param Questionnaire $questionnaire
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Questionnaire $questionnaire)
    {
        $questionnaire->delete();

        Toast::info(__('Questionnaire was removed'));

        return redirect()->route('platform.systems.questionnaires');
    }
}
