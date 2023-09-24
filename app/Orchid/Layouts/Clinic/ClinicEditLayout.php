<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Clinic;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Upload;

class ClinicEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('clinic.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Clinic Name')),

            Input::make('clinic.location')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Location'))
                ->id('clinic-location')
                ->placeholder(__('Clinic Location'))
                ->readonly(),

            Input::make('clinic.latitude')
                ->id('clinic-latitude')
                ->value('')->type('hidden'),

            Input::make('clinic.longitude')
                ->id('clinic-longitude')
                ->value('')->type('hidden'),

            Input::make('clinic.address')
                ->type('text')
                ->max(255)
                ->required()
                ->id('clinic-Address')
                ->title(__('Address'))
                ->placeholder(__('Clinic Address')),

            CheckBox::make('clinic.status')
                ->sendTrueOrFalse()
                ->value(1)
                ->title(__('Status'))
                ->placeholder(__('Clinic Status')),

            // Add the Banner Image Upload Field
            Upload::make('clinic.banner_image')
                ->title(__('Banner Image'))
                ->maxFiles(1) // Allow only one file to be uploaded
                ->acceptedFiles('image/*') // Accept only image files
                ->placeholder(__('Upload Clinic Banner Image')),

            // Add the Profile Icon Upload Field
            Upload::make('clinic.profile_icon')
                ->title(__('Profile Icon'))
                ->maxFiles(1) // Allow only one file to be uploaded
                ->acceptedFiles('image/*') // Accept only image files
                ->placeholder(__('Upload Clinic Profile Icon')),
        ];
    }
}
