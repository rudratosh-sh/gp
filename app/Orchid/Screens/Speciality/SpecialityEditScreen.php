<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Speciality;

use App\Models\Speciality;
use App\Orchid\Layouts\Speciality\SpecialityEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;

class SpecialityEditScreen extends Screen
{
    /**
     * @var Speciality
     */
    public $speciality;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Speciality $speciality): array
    {
        $this->speciality = $speciality ?? new Speciality();

        return [
            'speciality' => $this->speciality,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->speciality->exists ? 'Edit Speciality' : 'Create Speciality';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update speciality information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->speciality && $this->speciality->exists)
                ? 'platform.systems.specialities.edit'
                : 'platform.systems.specialities.create',
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
                ->confirm(__('Once the speciality is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->speciality->exists)
                ->can('platform.systems.specialities.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.specialities.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(SpecialityEditLayout::class)
                ->title(__('Speciality Information'))
                ->description(__('Update speciality\'s details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->speciality->exists)
                        ->can('platform.systems.specialities.edit')
                        ->method('save')
                ),
        ];
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Speciality $speciality, Request $request)
    {
        $speciality->fill($request->get('speciality'))->save();

        Toast::info(__('Speciality was saved.'));

        return redirect()->route('platform.systems.specialities');
    }

    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Speciality $speciality)
    {
        $speciality->delete();

        Toast::info(__('Speciality was removed'));

        return redirect()->route('platform.systems.specialities');
    }
}
