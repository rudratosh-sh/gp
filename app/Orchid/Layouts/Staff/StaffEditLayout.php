<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Staff;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Rows;
use App\Models\Staff;
use App\Models\Clinic;
use App\Models\User;

class StaffEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Select::make('staff.clinic_id')
                ->fromModel(Clinic::class, 'name')
                ->required()
                ->title(__('Clinic'))
                ->placeholder(__('Select Clinic')),

            Select::make('staff.user_id')
                ->fromModel(User::staffs()->get(), 'name', 'id')
                ->required()
                ->readonly()
                ->title(__('Name'))
                ->placeholder(__('Staff Name')),
        ];
    }
}
