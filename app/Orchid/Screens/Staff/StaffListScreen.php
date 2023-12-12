<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Staff;

use App\Models\Staff;
use App\Orchid\Layouts\Staff\StaffEditLayout;
use App\Orchid\Layouts\Staff\StaffFiltersLayout;
use App\Orchid\Layouts\Staff\StaffListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class StaffListScreen extends Screen
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
            'staffs' => Staff::defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Staff Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all staffs.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.staffs.view',
            'platform.systems.staffs.create',
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
                ->route('platform.systems.staffs.create')
                ->canSee($this->hasPermission('platform.systems.staffs.create')),
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
            StaffFiltersLayout::class,
            StaffListLayout::class,

            Layout::modal('asyncEditStaffModal', StaffEditLayout::class)
                ->async('asyncGetStaff'),
        ];
    }

    /**
     * Fetch staff data asynchronously for editing.
     *
     * @param Staff $staff
     *
     * @return array
     */
    public function asyncGetStaff(Staff $staff): array
    {
        return [
            'staff' => $staff,
        ];
    }

    /**
     * Save the staff data.
     *
     * @param Request $request
     * @param Staff  $staff
     */
    public function saveStaff(Request $request, Staff $staff): void
    {
        $staff->fill($request->input('staff'))->save();

        Toast::info(__('Staff was saved.'));
    }

    /**
     * Remove the staff.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Staff::findOrFail($request->get('id'))->delete();

        Toast::info(__('Staff was removed'));
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
