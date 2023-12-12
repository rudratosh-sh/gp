<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Staff;

use App\Models\Staff;
use App\Orchid\Layouts\Staff\StaffEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use App\Events\StaffCreated;
use App\Events\StaffUpdated;


class StaffEditScreen extends Screen
{
    /**
     * @var Staff
     */
    public $staff;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Staff $staff): array
    {
        $this->staff = $staff ?? new Staff();

        return [
            'staff' => $this->staff,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->staff->exists ? 'Edit Staff' : 'Create Staff';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update staff information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->staff && $this->staff->exists)
                ? 'platform.systems.staffs.edit'
                : 'platform.systems.staffs.create',
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
                ->confirm(__('Once the staff is deleted, all of their resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->staff->exists)
                ->can('platform.systems.staffs.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.staffs.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(StaffEditLayout::class)
                ->title(__('Staff Information'))
                ->description(__('Update staff\'s details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->staff->exists)
                        ->can('platform.systems.staffs.edit')
                        ->method('save')
                ),

            // Layout::rows([
            //     Input::make('doctor.name')
            //         ->title('Name')
            //         ->required(),

            //     Input::make('doctor.speciality')
            //         ->title('Speciality')
            //         ->required(),

            //     Input::make('doctor.price')
            //         ->title('Price')
            //         ->type('number')
            //         ->required(),
            // ]),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Staff $staff, Request $request)
    {
        $staff->fill($request->get('staff'));

        // Retrieve the speciality ID from the request or set it to null if not provided

        $staff->save();

        if ($staff->wasRecentlyCreated) {
            event(new StaffCreated($staff, $request->user()));
        } else {
            event(new StaffUpdated($staff, $request->user()));
        }

        Toast::info(__('Staff was saved.'));

        return redirect()->route('platform.systems.staffs');
    }



    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Staff $staff)
    {
        $staff->delete();

        Toast::info(__('Staff was removed'));

        return redirect()->route('platform.systems.staffs');
    }
}
