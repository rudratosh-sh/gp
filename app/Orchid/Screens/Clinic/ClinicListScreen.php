<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Clinic;

use App\Models\Clinic;
use App\Orchid\Layouts\Clinic\ClinicEditLayout;
use App\Orchid\Layouts\Clinic\ClinicFiltersLayout;
use App\Orchid\Layouts\Clinic\ClinicListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ClinicListScreen extends Screen
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
    // $filters = $request->input('filter', []);
    // $sort = $request->input('sort', 'id');
    // $direction = $request->input('dir', 'desc');

    // $clinics = Clinic::query()
    //     ->filters($filters) // Apply filters
    //     ->orderBy($sort, $direction) // Apply sorting
    //     ->paginate(); // Add pagination

    //     dd($clinics);
    // return [
    //     'clinics' => $clinics,
    // ];
    return [
        'clinics' => Clinic::defaultSort('id', 'desc')
            ->paginate(),
    ];
}


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Clinic Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all registered clinics.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.clinics.view',
            'platform.systems.clinics.create',
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        // dd($this->permission());
        return [
            Link::make(__('Add'))
                ->icon('bs.plus-circle')
                ->route('platform.systems.clinics.create')
                ->canSee($this->hasPermission('platform.systems.clinics.create')),
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
            ClinicFiltersLayout::class,
            ClinicListLayout::class,

            Layout::modal('asyncEditClinicModal', ClinicEditLayout::class)
                ->async('asyncGetClinic'),
        ];
    }

    /**
     * @return array
     */
    public function asyncGetClinic(Clinic $clinic): iterable
    {
        return [
            'clinic' => $clinic,
        ];
    }

    public function saveClinic(Request $request, Clinic $clinic): void
    {
        $clinic->fill($request->input('clinic'))->save();

        Toast::info(__('Clinic was saved.'));
    }

    public function remove(Request $request): void
    {
        Clinic::findOrFail($request->get('id'))->delete();

        Toast::info(__('Clinic was removed'));
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
