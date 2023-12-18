<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Orchid\Support\Facades\Toast;
use Illuminate\Http\Response;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Events\PusherBroadcast;
use App\Models\Message;
use Pusher\Pusher;
use App\Models\ClinicVitals;
use App\Models\PatientVitalsValues;
use Illuminate\Support\Facades\Crypt;

class DoctorController extends Controller
{
    public function signin(Request $request)
    {
        return view('doctor.users.signin');
    }

    public function signInProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required_without:mobile', 'email'],
            'mobile' => ['required_without:email', 'numeric'],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('doctor.signin.get')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password', 'mobile');
        $user = User::where(function ($query) use ($credentials) {
            $query->where('email', $credentials['email'])
                ->where('mobile', $credentials['mobile']);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'doctor'); // Check for the "doctor" role
            })
            ->with('doctor.clinic') // Eager load the doctor and clinic relationships
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            Toast::info(__('Invalid login credentials.'));
            return redirect()->route('doctor.signin.get')->with('error', 'Invalid login credentials.');
        }
        Auth::login($user);
        $request->session()->put('doctor', $user);

        return redirect()->route('doctor.dashboard.get');
    }

    public function dashboard(Request $request)
    {
        $doctor = $request->session()->get('doctor');
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', date('Y-m-d'))
            ->where('doctor_id', auth()->id())
            ->get();
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.booked-appointment', ['user' => $doctor, 'appointments' => $appointments]);
    }

    public function getAppointments(Request $request)
    {
        $selectedDate = $request->input('selectedDate');
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->where('doctor_id', auth()->id())
            ->get();

        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');
        return response()->json(['appointments' => $appointments]);
    }

    public function history(Request $request)
    {
        $doctor = $request->session()->get('doctor');
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', date('Y-m-d'))
            ->where('doctor_id', auth()->id())
            ->get();

        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues');

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.history', ['user' => $doctor, 'appointments' => $appointments]);
    }

    public function getHistory(Request $request)
    {
        $selectedDate = $request->input('selectedDate');
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->where('doctor_id', auth()->id())
            ->get();
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues');
        return response()->json([
            'appointments' => $appointments
        ]);
    }

    public function getPatientDetails(Request $request,$userId)
    {
        $userId = Crypt::decrypt($userId);
        $doctor = $request->session()->get('doctor');
        $appointment = Appointment::where('user_id', $userId)
            ->first();

        $appointment->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues');

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.patient-details', ['user' => $doctor,'appointment' => $appointment]);
    }
}
