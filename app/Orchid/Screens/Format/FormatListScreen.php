<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Format;

use App\Models\Format;
use App\Orchid\Layouts\Format\FormatFiltersLayout;
use App\Orchid\Layouts\Format\FormatListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class FormatListScreen extends Screen
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
            'formats' => Format::defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Format Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all formats.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.formats.view',
            'platform.systems.formats.create',
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
                ->route('platform.systems.formats.create')
                ->canSee($this->hasPermission('platform.systems.formats.create')),
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
            FormatFiltersLayout::class,
            FormatListLayout::class,

            // Add other layouts as needed
        ];
    }

    /**
     * Remove the format.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Format::findOrFail($request->get('id'))->delete();

        Toast::info(__('Format was removed'));
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
