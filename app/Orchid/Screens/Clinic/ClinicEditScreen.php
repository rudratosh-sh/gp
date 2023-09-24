<?php

declare(strict_types=1);

namespace App\Orchid\Screens\Clinic;

use App\Models\Clinic;
use App\Orchid\Layouts\Clinic\ClinicEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;
use Orchid\Support\Color;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Layouts\Columns;
use Orchid\Screen\Fields\Upload;


class ClinicEditScreen extends Screen
{
    /**
     * @var Clinic
     */
    public $clinic;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(?Clinic $clinic): array
    {
        $this->clinic = $clinic ?? new Clinic();

        return [
            'clinic' => $this->clinic,
        ];
    }


    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return $this->clinic->exists ? 'Edit Clinic' : 'Create Clinic';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'Update clinic information';
    }

    public function permission(): ?iterable
    {
        return [
            ($this->clinic && $this->clinic->exists)
                ? 'platform.systems.clinics.edit'
                : 'platform.systems.clinics.create',
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
                ->confirm(__('Once the clinic is deleted, all of its resources and data will be permanently deleted.'))
                ->method('remove')
                ->canSee($this->clinic->exists)
                ->can('platform.systems.clinics.delete'),

            Button::make(__('Save'))
                ->icon('bs.check-circle')
                ->method('save')
                ->can('platform.systems.clinics.edit'),
        ];
    }

    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(ClinicEditLayout::class)
                ->title(__('Clinic Information'))
                ->description(__('Update clinic\'s details here.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::PRIMARY)
                        ->icon('bs.check-circle')
                        ->canSee($this->clinic->exists)
                        ->can('platform.systems.clinics.edit')
                        ->method('save')
                ),

            // Add Google Autocomplete input fields
            // Layout::rows([
            //     // Input::make('clinic.location')
            //     //     ->title('Location')
            //     //     ->required()
            //     //     ->id('clinic-location'),

            //     // Input::make('clinic.latitude')
            //     //     ->title('Latitude')
            //     //     ->readonly()
            //     //     ->id('clinic-latitude'),

            //     // Input::make('clinic.longitude')
            //     //     ->title('Longitude')
            //     //     ->readonly()
            //     //     ->id('clinic-longitude'),

            //     // Add the Banner Image Upload Field
            //     // Upload::make('clinic.banner_image')
            //     //     ->title(__('Banner Image'))
            //     //     ->maxFiles(1) // Allow only one file to be uploaded
            //     //     ->acceptedFiles('image/*') // Accept only image files
            //     //     ->placeholder(__('Upload Clinic Banner Image')),

            //     // // Add the Profile Icon Upload Field
            //     // Upload::make('clinic.profile_icon')
            //     //     ->title(__('Profile Icon'))
            //     //     ->maxFiles(1) // Allow only one file to be uploaded
            //     //     ->acceptedFiles('image/*') // Accept only image files
            //     //     ->placeholder(__('Upload Clinic Profile Icon')),
            // ]),
        ];
    }



    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Clinic $clinic, Request $request)
    {
        // Fill the clinic data from the request
        $clinicData = $request->input('clinic');

        // Handle the file uploads
        if ($request->hasFile('clinic.banner_image')) {
            $bannerImage = $request->file('clinic.banner_image');
            $clinicData['banner_image'] = $bannerImage->store('clinic_images', 'public');
        }

        if ($request->hasFile('clinic.profile_icon')) {
            $profileIcon = $request->file('clinic.profile_icon');
            $clinicData['profile_icon'] = $profileIcon->store('clinic_images', 'public');
        }

        $clinic->fill($clinicData)->save();
        Toast::info(__('Clinic was saved.'));
        return redirect()->route('platform.systems.clinics');
    }


    /**
     * @throws \Exception
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Clinic $clinic)
    {
        $clinic->delete();

        Toast::info(__('Clinic was removed'));

        return redirect()->route('platform.systems.clinics');
    }

    public function scripts(): array
    {
        return [
            <<<JS
        function initialize() {
            var input = document.getElementById('clinic-location');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
                document.getElementById('clinic-latitude').value = place.geometry.location.lat();
                document.getElementById('clinic-longitude').value = place.geometry.location.lng();
            });
        }
        JS,
        ];
    }
}
