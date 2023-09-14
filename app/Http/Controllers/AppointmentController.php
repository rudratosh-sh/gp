<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;


class AppointmentController extends Controller
{
    // Display the Dashboard
    public function index(Request $request)
    {
        if (auth()->check()) {
            // If authenticated, retrieve the authenticated user's data
            $user = auth()->user();
        } else {
            // If not authenticated, return a 404 error
            abort(Response::HTTP_FORBIDDEN);
        }
        // Retrieve the list of unique locations from the Clinic model
        $locations = Clinic::all();
        // Retrieve the list of doctors from the Doctor model
        $doctors = Doctor::all(); // You can modify this query as needed

        return view('front.appointment.booking-appointment', ['user' => $user, 'locations' => $locations, 'doctors' => $doctors]);
    }

    public function searchClinicsDoctors(Request $request)
    {
        // Retrieve the selected location and specialist
        $locationId = $request->input('location');
        $specialistId = $request->input('specialist');

        $clinics = Clinic::where('id', $locationId)->get();
        // Fetch doctors based on the selected specialist
        $doctors = Doctor::where('id', $specialistId)->with('clinic')->get();

        // If no doctors are found for the selected specialist, fetch doctors based on the clinic's location
        if ($doctors->isEmpty()) {
            $doctors = Doctor::whereHas('clinic', function ($query) use ($locationId) {
                $query->where('id', $locationId);
            })->get();
        }

        // Return the search results as JSON
        return response()->json(['clinics' => $clinics, 'doctors' => $doctors]);
    }

    public function questionnaire($doctorId)
    {
        // Fetch the doctor information using the $doctorId
        $doctor = Doctor::find($doctorId);

        if (!$doctor) {
            // Handle the case where the doctor is not found
            abort(404);
        }

        // Fetch all clinics associated with this doctor
        $clinics = Clinic::whereHas('doctors', function ($query) use ($doctor) {
            $query->where('id', $doctor->id);
        })->get();

        // Fetch all questions with section_id = 1
        $questions = Question::where('section_id', 1)->get();

        return view('front.appointment.questionnaire', compact('clinics', 'doctor', 'questions'));
    }

    public function questionnaireStore(Request $request)
    {
        // Retrieve data from the form submission
        $doctorId = $request->input('doctor_id');
        $answers = $request->input('answers'); // Retrieve all question answers as an array

        // Store the data in Laravel's session
        $userData = [
            'doctor_id' => $doctorId,
            'answers' => $answers, // Store the answers array in the session
        ];

        $request->session()->put('user_data', $userData);

        // Redirect to the schedule page
        return redirect()->route('appointment.schedule')->with($userData,$userData);
    }

    public function schedule(Request $request)
    {
        $userData = $request->session()->get('user_data');
        return view('front.appointment.schedule', ['userData' => $userData ]);
    }
}
