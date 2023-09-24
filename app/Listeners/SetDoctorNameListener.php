<?php

namespace App\Listeners;

use App\Events\DoctorCreated;
use App\Events\DoctorUpdated;

class SetDoctorNameListener
{
    public function handle(DoctorCreated $event)
    {
        $doctor = $event->doctor;
        $user = $event->user;

        // Check if the user has the "doctor" role
        if ($user->hasRole('doctor')) {
            // Set the doctor's name to the user's name
            $doctor->name = $user->name;
            $doctor->save();
        }
    }

    public function updated(DoctorUpdated $event)
    {
        $doctor = $event->doctor;
        $user = $event->user;

        // Check if the user has the "doctor" role
        if ($user->hasRole('doctor')) {
            // Set the doctor's name to the user's name
            $doctor->name = $user->name;
            $doctor->save();
        }
    }
}
