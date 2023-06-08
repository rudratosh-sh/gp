<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Section;

use App\Models\Section;
use App\Orchid\Layouts\Section\SectionListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class SectionListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Request $request
     * @return array
     */
    public function query(Request $request): array
    {
        return [
            'sections' => Section::orderBy('questionnaire_id')->orderBy('order')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Section Management';
    }

    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all sections.';
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
                ->route('platform.systems.sections.create'),
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
            SectionListLayout::class,
        ];
    }

    /**
     * Save the section data.
     *
     * @param Request $request
     * @param Section $section
     */
    public function saveSection(Request $request, Section $section): void
    {
        $section->fill($request->input('section'))->save();

        Toast::info(__('Section was saved.'));
    }

    /**
     * Remove the section.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Section::findOrFail($request->get('id'))->delete();

        Toast::info(__('Section was removed'));
    }
}
