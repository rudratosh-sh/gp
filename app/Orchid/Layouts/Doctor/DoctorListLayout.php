<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Doctor;

use App\Models\Doctor;
use App\Models\Speciality;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class DoctorListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'doctors';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Doctor $doctor) {
                    return Link::make($doctor->user->name)
                        ->route('platform.systems.doctors.edit', $doctor->id)
                        ->icon('bs.pencil');
                }),

            TD::make('price', __('Price'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Doctor $doctor) {
                    return $doctor->price;
                }),

            TD::make('speciality.name', __('Speciality'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Doctor $doctor) {
                    return $doctor->speciality->name;
                }),

            TD::make('clinic.name', __('Clinic'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Doctor $doctor) {
                    return $doctor->clinic->name;
                }),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Doctor $doctor) {
                    return $doctor->updated_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Doctor $doctor) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $doctor->id]);
                }),
        ];
    }
}
