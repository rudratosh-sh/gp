<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Speciality;

use App\Models\Speciality;
use App\Orchid\Layouts\Speciality\SpecialityListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class SpecialityListScreen extends Screen
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
            'specialities' => Speciality::defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Speciality Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all specialities.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.specialities.view',
            'platform.systems.specialities.create',
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
                ->route('platform.systems.specialities.create')
                ->canSee($this->hasPermission('platform.systems.specialities.create')),
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
            SpecialityListLayout::class,
        ];
    }

    /**
     * Remove the speciality.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Speciality::findOrFail($request->get('id'))->delete();

        Toast::info(__('Speciality was removed'));
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
