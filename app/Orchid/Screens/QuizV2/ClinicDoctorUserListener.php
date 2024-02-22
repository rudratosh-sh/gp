<?php

namespace App\Orchid\Screens\QuizV2;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Layouts\Listener;
use Orchid\Screen\Repository;
use Orchid\Support\Facades\Layout;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Appointment;

class ClinicDoctorUserListener extends Listener
{
    protected $targets = [
        'quiz.clinic_id',
        'quiz.doctor_id',
    ];

    protected function layouts(): array
    {
        return [
            Layout::rows([
                Select::make('quiz.clinic_id')
                    ->fromModel(Clinic::class, 'name', 'id')
                    ->title(__('Clinic'))
                    ->empty('Select Clinic')
                    ->placeholder(__('Select Clinic'))
                    ->col('offset-9'), // Offset the column to the right

                Select::make('quiz.doctor_id')
                    ->options($this->query->get('quiz.doctor_options', []))
                    ->title(__('Doctor'))
                    ->placeholder(__('Select Doctor'))
                    ->col('offset-9'), // Offset the column to the right

                Select::make('quiz.user_id')
                    ->options($this->query->get('quiz.user_options', []))
                    ->title(__('User'))
                    ->multiple()
                    ->placeholder(__('Select User'))
                    ->col('offset-9'), // Offset the column to the right
            ]),
        ];
    }

    public function handle(Repository $repository, Request $request): Repository
    {
        $clinicId = $request->input('quiz.clinic_id');
        $doctors = Doctor::where('clinic_id', $clinicId)->get();
        $doctorOptions = $doctors->map(function ($doctor) {
            return [
                'user_id' => $doctor->user_id,
                'name' => $doctor->user->name,
            ];
        })->pluck('name', 'user_id')->prepend('Select Doctor', '');

        $repository->set('quiz.clinic_id', $clinicId);
        $doctorId = $request->input('quiz.doctor_id');
        $userIds = Appointment::where('doctor_id', $doctorId)->pluck('user_id')->toArray();
        $users = User::whereIn('id', $userIds)->get();
        $userOptions = $users->pluck('name', 'id')->prepend('Select User', '');

        return $repository
            ->set('quiz.doctor_id', $doctorId) // Preserve the selected doctor
            ->set('quiz.doctor_options', $doctorOptions)
            ->set('quiz.user_id', null)
            ->set('quiz.user_options', $userOptions);
    }
}
