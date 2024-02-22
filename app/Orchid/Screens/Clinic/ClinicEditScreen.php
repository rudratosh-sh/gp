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

        // Check if 'banner_image' key exists before accessing it
        if (isset($clinicData['banner_image'])) {
            $clinicData['banner_image'] = $clinicData['banner_image'][0];
        } else {
            // Handle the case when 'banner_image' key is not found, for example, set it to null
            $clinicData['banner_image'] = null; // or any other default value you prefer
        }

        // Check if 'profile_icon' key exists before accessing it
        if (isset($clinicData['profile_icon'])) {
            $clinicData['profile_icon'] = $clinicData['profile_icon'][0];
        } else {
            // Handle the case when 'profile_icon' key is not found, for example, set it to null
            $clinicData['profile_icon'] = null; // or any other default value you prefer
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
                var input = document.getElementById('clinic-Address');
                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.addListener('place_changed', function () {
                    var place = autocomplete.getPlace();

                    if (!place.geometry) {
                        return;
                    }

                    // Fill in the latitude and longitude fields
                    document.getElementById('clinic-latitude').value = place.geometry.location.lat();
                    document.getElementById('clinic-longitude').value = place.geometry.location.lng();

                    // Fill in the city, state, and country fields (modify as needed)
                    for (var component of place.address_components) {
                        if (component.types.includes('locality')) {
                            document.getElementById('clinic-city').value = component.long_name;
                        }
                        if (component.types.includes('administrative_area_level_1')) {
                            document.getElementById('clinic-state').value = component.long_name;
                        }
                        if (component.types.includes('country')) {
                            document.getElementById('clinic-country').value = component.long_name;
                        }
                    }
                });
            }
            JS,
        ];
    }
}
