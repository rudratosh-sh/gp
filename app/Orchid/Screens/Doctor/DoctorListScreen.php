<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Doctor;

use App\Models\Doctor;
use App\Orchid\Layouts\Doctor\DoctorEditLayout;
use App\Orchid\Layouts\Doctor\DoctorFiltersLayout;
use App\Orchid\Layouts\Doctor\DoctorListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class DoctorListScreen extends Screen
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
            'doctors' => Doctor::defaultSort('id', 'desc')->paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Doctor Management';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A comprehensive list of all doctors.';
    }

    public function permission(): ?iterable
    {
        return [
            'platform.systems.doctors.view',
            'platform.systems.doctors.create',
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
                ->route('platform.systems.doctors.create')
                ->canSee($this->hasPermission('platform.systems.doctors.create')),
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
            DoctorFiltersLayout::class,
            DoctorListLayout::class,

            Layout::modal('asyncEditDoctorModal', DoctorEditLayout::class)
                ->async('asyncGetDoctor'),
        ];
    }

    /**
     * Fetch doctor data asynchronously for editing.
     *
     * @param Doctor $doctor
     *
     * @return array
     */
    public function asyncGetDoctor(Doctor $doctor): array
    {
        return [
            'doctor' => $doctor,
        ];
    }

    /**
     * Save the doctor data.
     *
     * @param Request $request
     * @param Doctor  $doctor
     */
    public function saveDoctor(Request $request, Doctor $doctor): void
    {
        $doctor->fill($request->input('doctor'))->save();

        Toast::info(__('Doctor was saved.'));
    }

    /**
     * Remove the doctor.
     *
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Doctor::findOrFail($request->get('id'))->delete();

        Toast::info(__('Doctor was removed'));
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
