<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Doctor;

use App\Models\Doctor;
use App\Orchid\Layouts\Doctor\DoctorEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use App\Events\DoctorCreated;
use App\Events\DoctorUpdated;


class DoctorEditScreen extends Screen
{
    /**
     * @var Doctor
     */
    public $doctor;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Doctor $doctor): array
    {
        $this->doctor = $doctor ?? new Doctor();

        return [
            'doctor' => $this->doctor,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->doctor->exists ? 'Edit Doctor' : 'Create Doctor';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update doctor information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->doctor && $this->doctor->exists)
                ? 'platform.systems.doctors.edit'
                : 'platform.systems.doctors.create',
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
                ->confirm(__('Once the doctor is deleted, all of their resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->doctor->exists)
                ->can('platform.systems.doctors.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.doctors.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(DoctorEditLayout::class)
                ->title(__('Doctor Information'))
                ->description(__('Update doctor\'s details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->doctor->exists)
                        ->can('platform.systems.doctors.edit')
                        ->method('save')
                ),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Doctor $doctor, Request $request)
    {
        $doctor->fill($request->get('doctor'));

        // Retrieve the speciality ID from the request or set it to null if not provided
        $specialityId = $request->input('doctor.speciality', null);
        $doctor->speciality_id = $specialityId;

        $doctor->save();

        if ($doctor->wasRecentlyCreated) {
            event(new DoctorCreated($doctor, $request->user()));
        } else {
            event(new DoctorUpdated($doctor, $request->user()));
        }

        Toast::info(__('Doctor was saved.'));

        return redirect()->route('platform.systems.doctors');
    }



    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Doctor $doctor)
    {
        $doctor->delete();

        Toast::info(__('Doctor was removed'));

        return redirect()->route('platform.systems.doctors');
    }
}
