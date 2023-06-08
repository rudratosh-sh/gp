<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Speciality;

use App\Models\Speciality;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class SpecialityListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'specialities';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Speciality $speciality) {
                    return $speciality->name;
                }),

            TD::make('status', __('Status'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Speciality $speciality) {
                    return $speciality->status ? 'Active' : 'Inactive';
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Speciality $speciality) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $speciality->id]);
                }),
        ];
    }
}
