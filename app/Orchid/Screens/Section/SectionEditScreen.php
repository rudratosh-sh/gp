<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Section;

use App\Models\Section;
use App\Orchid\Layouts\Section\SectionEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class SectionEditScreen extends Screen
{
    /**
     * @var Section
     */
    public $section;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Section|null $section
     * @return array
     */
    public function query(?Section $section): array
    {
        $this->section = $section ?? new Section();

        return [
            'section' => $this->section,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->section->exists ? 'Edit Section' : 'Create Section';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Update section information';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.sections.edit'),
        ];
    }

    /**
     * Define the layout of the screen.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layout::block(SectionEditLayout::class)
                ->title(__('Section Information'))
                ->description(__('Update section details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->can('platform.systems.sections.edit')
                        ->method('save')
                ),
        ];
    }

    /**
     * Save the section data.
     *
     * @param Section $section
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Section $section, Request $request)
    {
        $data = $request->validate([
            'section.name' => 'required|string|max:255',
            'section.questionnaire_id' => 'required',
            // Add validation rules for other fields here
        ]);

        $section->fill($data['section']);
        $section->save();

        Toast::info(__('Section was saved.'));

        return redirect()->route('platform.systems.sections');
    }
}
