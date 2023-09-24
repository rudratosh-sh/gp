<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Doctor;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Doctor;
use App\Models\Clinic;
use App\Models\User;
use App\Models\Speciality;

class DoctorEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('doctor.clinic_id')
                ->fromModel(Clinic::class, 'name')
                ->required()
                ->title(__('Clinic'))
                ->placeholder(__('Select Clinic')),

            Select::make('doctor.user_id')
                ->fromModel(User::doctors()->get(), 'name', 'id')
                ->required()
                ->readonly()
                ->title(__('Name'))
                ->placeholder(__('Doctor Name')),

            Input::make('doctor.price')
                ->type('number')
                ->max(999999.99)
                ->required()
                ->step(0.01)
                ->title(__('Price'))
                ->placeholder(__('Price')),

            Select::make('doctor.speciality')
                ->fromModel(Speciality::class, 'name')
                ->required()
                ->title(__('Speciality'))
                ->placeholder(__('Select Speciality')),

            // Add other fields as needed
        ];
    }
}
