<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Clinic;

use App\Models\Clinic;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Image as ImageField;
use Orchid\Support\Facades\Layout;
use App\Models\Attachment;

class ClinicListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'clinics';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => Link::make($clinic->name)
                    ->route('platform.systems.clinics.edit', $clinic->id)
                    ->icon('bs.pencil')),

            TD::make('location', __('Location'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->location),

            TD::make('banner_image', __('Banner Image'))
                ->render(function (Clinic $clinic) {

                    if ($clinic->banner_image) {
                        // Assuming 'Attachment' is the model for attachments
                        $bannerImage = Attachment::find($clinic->banner_image); // Get the first attachment by ID
                        $basePath = 'storage/'; // Define the base path where the images are stored
                        if ($bannerImage) {
                            // Render the Blade component for the image preview
                            return view('components.clinic_banner_image', ['image' => url($basePath.$bannerImage->path.$bannerImage->name.'.'.$bannerImage->extension)]);
                        }
                    }

                    // If there's no image or an issue with the data, display a placeholder or empty text
                    return __('No Image');
                }),


            TD::make('latitude', __('Latitude'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->latitude),

            TD::make('longitude', __('Longitude'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->longitude),

            TD::make('status', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->status),

            TD::make('address', __('Address'))
                ->sort()
                ->filter(Input::make())
                ->render(fn (Clinic $clinic) => $clinic->address),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(fn (Clinic $clinic) => $clinic->updated_at->toDateTimeString()),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Clinic $clinic) => Button::make(__('Delete'))
                    ->icon('bs.trash3')
                    ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                    ->method('remove', [
                        'id' => $clinic->id,
                    ])),
        ];
    }
}
