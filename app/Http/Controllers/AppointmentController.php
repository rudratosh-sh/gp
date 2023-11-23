<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Clinic;
use App\Models\Doctor;
use App\Models\Question;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use DateTime;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\WebSocketNotification;
use App\Events\AppointmentCreated;

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
        $locations = Clinic::with(['bannerImage', 'profileIcon'])->get();

        // Retrieve the list of doctors along with their user details
        $doctors = Doctor::with('user')->get();

        return view('patient.appointment.booking-appointment', ['user' => $user, 'locations' => $locations, 'doctors' => $doctors]);
    }

    public function searchClinicsDoctors(Request $request)
    {
        // Retrieve the selected location and specialist
        $locationId = $request->input('location');
        $specialistId = $request->input('specialist');

        // Fetch clinics based on the selected location
        $clinics = Clinic::where('id', $locationId)
            ->with(['bannerImage', 'profileIcon']) // Load banner image and profile icon relationships
            ->get();

        // Fetch doctors based on the selected specialist
        $doctors = Doctor::where('user_id', $specialistId)
            ->with(['clinic', 'user', 'clinic.bannerImage', 'clinic.profileIcon']) // Load necessary relationships
            ->get();

        // If no doctors are found for the selected specialist, fetch doctors based on the clinic's location
        if ($doctors->isEmpty()) {
            $doctors = Doctor::whereHas('clinic', function ($query) use ($locationId) {
                $query->where('id', $locationId);
            })
                ->with(['user', 'clinic.bannerImage', 'clinic.profileIcon']) // Load necessary relationships
                ->get();
        }

        // Return the search results as JSON
        return response()->json(['clinics' => $clinics, 'doctors' => $doctors]);
    }

    public function questionnaire($doctorId)
    {
        // Fetch the doctor information using the $doctorId
        $doctor = Doctor::where('user_id', $doctorId)->first();

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

        return view('patient.appointment.questionnaire', compact('clinics', 'doctor', 'questions'));
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
        return redirect()->route('appointment.schedule')->with($userData, $userData);
    }

    public function schedule(Request $request)
    {
        $userData = $request->session()->get('user_data');
        $events = [];

        $appointments = Appointment::all();

        foreach ($appointments as $appointment) {
            $events[] = [
                'title' => 'jack appointment ',
                'start' => '2023-10-21 17:00:00',
                'end' => '2023-10-21 17:30:00',
            ];
        }
        return view('patient.appointment.schedule', ['userData' => $userData, 'events' => $events]);
    }


    // Create
    public function storeAppointment(Request $request)
    {
        // Validate the request data (you can customize validation rules)
        $validatedData = $request->validate([
            'selectedTime' => 'required', // Assuming 'selectedTime' contains the time in 12-hour format, e.g., "09:00 AM"
            'selectedDate' => 'required', // Assuming 'selectedDate' contains the date in the format, e.g., "2023-09-23"
            'selectedDetails' => 'nullable|string',
        ]);

        // Get the authenticated user (assuming you are using Laravel's built-in authentication)
        $user = Auth::user();

        // Get the 'doctor_id' from the session data
        $doctorId = $request->session()->get('user_data.doctor_id');
        if (!$doctorId) {
            // Flash an error message to the session
            return Redirect::route('appointment.schedule')->withErrors(['error' => 'Doctor not found']);
        }
        // Retrieve the Doctor model based on the doctor_id
        $doctor = Doctor::where('user_id',$doctorId)->first();

        // You can extract the 'clinic_id' from the relationship if it's available in your session data
        $clinicId = $doctor->clinic_id; // Replace this with the actual clinic_id

        // Use the extracted 'selectedTime' and 'selectedDate' to create the 'appointment_date_time' and 'slot' fields
        $appointmentDateTime = date('Y-m-d H:i:s', strtotime($validatedData['selectedDate'] . ' ' . $validatedData['selectedTime']));

        // Create a new appointment record
        $appointment = Appointment::create([
            'clinic_id' => $clinicId,
            'doctor_id' => $doctorId,
            'user_id' => $user->id,
            'appointment_date_time' => $appointmentDateTime,
            'slot' => $validatedData['selectedDate'],
            'details' => $validatedData['selectedDetails'],
        ]);

        if($appointment){
            $receiverId = $request->input('receiver_id'); // Replace this with your receiver ID retrieval logic
            $notificationData = [
                'sender_id' => Auth::id(), // The ID of the user triggering the notification
                'receiver_id' => $doctorId,
                'message' => "  has been scheduled an appointment for  ",
                'title' => 'New Appointment Scheduled',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' =>$doctorId,
            ];
            // dd($notificationData);

            WebSocketNotification::create($notificationData);
        }
        // Return a response (you can customize the response format)
        return Redirect::route('dashboard.index.get')->with('success', 'Appointment created successfully');
    }

    // Read (List)
    public function getAppointments()
    {
        // Get a list of all appointments
        $appointments = Appointment::all();

        // Load related data (e.g., doctor and clinic details) if necessary
        // You can eager load relationships to avoid N+1 query issues
        $appointments->load('doctor', 'clinic');

        // Return the Blade view with the appointments data
        return view('patient.appointment.list', compact('appointments'));
    }

    // Read (Show)
    public function showAppointment($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Return a response (you can customize the response format)
        return response()->json(['data' => $appointment]);
    }

    // Update
    public function updateAppointment(Request $request, $id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Validate the request data (you can customize validation rules)
        $validatedData = $request->validate([
            'clinic_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'user_id' => 'required|integer',
            'appointment_date_time' => 'required|date',
            'slot' => 'required|string',
            'details' => 'nullable|string',
        ]);

        // Update the appointment record
        $appointment->update($validatedData);

        // Return a response (you can customize the response format)
        return response()->json(['message' => 'Appointment updated', 'data' => $appointment]);
    }

    // Delete
    public function destroyAppointment($id)
    {
        // Find the appointment by ID
        $appointment = Appointment::findOrFail($id);

        // Delete the appointment record
        $appointment->delete();

        // Return a response (you can customize the response format)
        return response()->json(['message' => 'Appointment deleted']);
    }

    public function getAppointmentsByDate($date)
    {
        // Convert the date string to a DateTime object with "m-d-Y" format
        $dateObj = DateTime::createFromFormat('m-d-Y H:i:s', $date . ' 00:00:00');

        if (!$dateObj) {
            // Handle invalid date format
            return response()->json(['error' => 'Invalid date format'], 400);
        }

        // Fetch appointments for the given date and include related data
        $appointments = Appointment::with(['doctor', 'clinic'])
            ->whereDate('appointment_date_time', $dateObj->format('Y-m-d'))
            ->get();

        // Transform the data to the desired format
        $formattedAppointments = $appointments->map(function ($appointment) {
            return [
                'date' => $appointment->appointment_date_time,
                'timeslot' => $appointment->slot, // Adjust the format as needed
                'doctor' => $appointment->doctor->name,
                'clinic' => $appointment->clinic->name,
                'details' => $appointment->details,
            ];
        });

        // Return the appointments as JSON response
        return response()->json(['data' => $formattedAppointments]);
    }
}
