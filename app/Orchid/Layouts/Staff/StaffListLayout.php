<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\Staff;

use App\Models\Staff;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class StaffListLayout extends Table
{
    /**
     * @var string
     */
    public $target = 'staffs';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::make('name', __('Name'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Staff $staff) {
                    return Link::make($staff->user->name)
                        ->route('platform.systems.staffs.edit', $staff->id)
                        ->icon('bs.pencil');
                }),

            TD::make('clinic.name', __('Clinic'))
                ->sort()
                ->filter(Input::make())
                ->render(function (Staff $staff) {
                    return $staff->clinic->name;
                }),

            TD::make('updated_at', __('Last edit'))
                ->sort()
                ->render(function (Staff $staff) {
                    return $staff->updated_at->toDateTimeString();
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Staff $staff) {
                    return Button::make(__('Delete'))
                        ->icon('bs.trash3')
                        ->confirm(__('Once the record is deleted, all of its resources and data will be permanently deleted. Before deleting the record, please download any data or information that you wish to retain.'))
                        ->method('remove', ['id' => $staff->id]);
                }),
        ];
    }
}
