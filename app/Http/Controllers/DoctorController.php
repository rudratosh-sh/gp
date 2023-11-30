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

class DoctorController extends Controller
{
    public function signin(Request $request)
    {
        // Auth::logout();
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
            // Invalid credentials, redirect back to login page
            Toast::info(__('Invalid login credentials.'));
            return redirect()->route('doctor.signin.get')->with('error', 'Invalid login credentials.');
        }
        // Authenticating the user via Laravel's Auth system
        Auth::login($user);
        // Authentication successful, store user data in session
        $request->session()->put('doctor', $user);

        // Redirect to the doctor's dashboard or any desired route
        return redirect()->route('doctor.dashboard.get');
    }

    public function dashboard(Request $request)
    {
        // Retrieve the 'doctor' variable from the session
        $doctor = $request->session()->get('doctor');
        // Get a list of all appointments
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', date('Y-m-d'))
                        ->where('doctor_id', auth()->id()) // Assuming the current user ID is the doctor's ID
                        ->get();
        // Load related data (e.g., doctor and clinic details) if necessary
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');

        if (auth()->check()) {
            // If authenticated, retrieve the authenticated user's data
            $user = auth()->user();
        } else {
            // If not authenticated, return a 404 error
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.booked-appointment', ['user' => $doctor, 'appointments' => $appointments]);
    }
    public function getAppointments(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        // Log the selected date
        Log::info('Selected Date: ' . $selectedDate . 'id' . auth()->id());

        // Retrieve appointments based on the date part of the appointment_date_time
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->where('doctor_id', auth()->id()) // Assuming the current user ID is the doctor's ID
            ->get();

        // Log the generated SQL query
        Log::info('SQL Query: ' . Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->where('doctor_id', auth()->id())->toSql());

        // Load related data if necessary
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');

        // Return the appointments as JSON
        return response()->json(['appointments' => $appointments]);
    }
}
