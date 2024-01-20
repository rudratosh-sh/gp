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
use App\Events\AppointmentCreated;
use App\Events\NotificationBroadcast;
use App\Models\Notification;
use Illuminate\Support\Str;
use App\Models\Meeting;

class AppointmentController extends Controller
{

    // Display the Dashboard
    public function index(Request $request)
    {
        // $title = 'New Notification Title';
        // $message = 'This is a test notification message.';

        // event(new NotificationEvent($title, $message));

        if (auth()->check()) {
            // If authenticated, retrieve the authenticated user's data
            $user = auth()->user();
        } else {
            // If not authenticated, return a 404 error
            abort(Response::HTTP_FORBIDDEN);
        }
        $user = auth()->user();

        // Retrieve the list of unique locations from the Clinic model
        $locations = Clinic::with(['bannerImage', 'profileIcon'])->get();

        // Retrieve the list of doctors along with their user details
        $doctors = Doctor::with('user')->get();

        return view('patient.appointment.booking-appointment', ['user' => $user, 'locations' => $locations, 'doctors' => $doctors]);
    }

    public function searchClinicsDoctors(Request $request)
    {
        $locationId = $request->input('location');
        $specialistId = $request->input('specialist');
        $clinics = Clinic::where('id', $locationId)
            ->with(['bannerImage', 'profileIcon'])
            ->get();

        $doctors = Doctor::where('user_id', $specialistId)
            ->with(['clinic', 'user', 'clinic.bannerImage', 'clinic.profileIcon'])
            ->get();

        if ($doctors->isEmpty()) {
            $doctors = Doctor::whereHas('clinic', function ($query) use ($locationId) {
                $query->where('id', $locationId);
            })
                ->with(['user', 'clinic.bannerImage', 'clinic.profileIcon'])
                ->get();
        }
        return response()->json(['clinics' => $clinics, 'doctors' => $doctors]);
    }

    public function questionnaire($doctorId, $bookingType)
    {
        $doctor = Doctor::where('user_id', $doctorId)->first();
        if (!$doctor) {
            abort(404);
        }
        $clinics = Clinic::whereHas('doctors', function ($query) use ($doctor) {
            $query->where('id', $doctor->id);
        })->get();
        $questions = Question::where('section_id', 1)->get();
        return view('patient.appointment.questionnaire', compact('clinics', 'doctor', 'questions', 'bookingType'));
    }

    public function questionnaireStore(Request $request, $bookingType)
    {
        $doctorId = $request->input('doctor_id');
        $answers = $request->input('answers');
        $userData = [
            'doctor_id' => $doctorId,
            'answers' => $answers,
            'booking_type' => $bookingType
        ];

        $request->session()->put('user_data', $userData);
        return redirect()->route('appointment.schedule')->with($userData, $userData);
    }

    public function schedule(Request $request)
    {
        $userData = $request->session()->get('user_data');
        $events = [];

        $data = Doctor::with(['clinic', 'user'])
            ->where('user_id', $userData['doctor_id'])
            ->firstOrFail();

        $appointments = Appointment::all();

        $userDetails = User::find(25);
        $notification = Notification::first();
        // Broadcast the event with notification and user details
        broadcast(new NotificationBroadcast($notification, 25, $userDetails));

        return view('patient.appointment.schedule', ['userData' => $userData, 'data' => $data]);
    }

    public function storeAppointment(Request $request)
    {
        $validatedData = $request->validate([
            'selectedTime' => 'required',
            'selectedDate' => 'required',
            'selectedDetails' => 'nullable|string',
        ]);
        $user = Auth::user();

        $doctorId = $request->session()->get('user_data.doctor_id');
        $booking_type = $request->session()->get('user_data.booking_type');
        if (!$doctorId) {
            return Redirect::route('appointment.schedule')->withErrors(['error' => 'Doctor not found']);
        }
        $doctor = Doctor::where('user_id', $doctorId)->first();
        $clinicId = $doctor->clinic_id;
        $appointmentDateTime = date('Y-m-d H:i:s', strtotime($validatedData['selectedDate'] . ' ' . $validatedData['selectedTime']));

        $appointment = Appointment::create([
            'clinic_id' => $clinicId,
            'doctor_id' => $doctorId,
            'user_id' => $user->id,
            'appointment_date_time' => $appointmentDateTime,
            'slot' => $validatedData['selectedDate'],
            'details' => $validatedData['selectedDetails'],
            'booking_type' => $booking_type
        ]);

        if ($appointment) {
            if ($booking_type == 'video') {
                $meeting = new Meeting();
                $meeting->meeting_id = Str::uuid();
                $meeting->appointment_id = $appointment->id;
                $meeting->save();
            }

            $receiverId = $request->input('receiver_id');
            $notificationData = [
                'sender_id' => Auth::id(),
                'receiver_id' => $doctorId,
                'message' => "  has been scheduled an appointment for  ",
                'title' => 'New Appointment Scheduled',
                'notifiable_type' => 'App\Models\User',
                'notifiable_id' => $doctorId,
            ];
        }
        return Redirect::route('dashboard.index.get')->with('success', 'Appointment created successfully');
    }

    public function getAppointments()
    {
        $appointments = Appointment::where('user_id', auth()->user()->id)->get();
        $appointments->load('doctor', 'clinic', 'user','meeting');
        return view('patient.appointment.list', compact('appointments'));
    }

    public function showAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $user = Auth::user();
        if ($appointment->user_id !== $user->id) {
            return response()->json(['data' => null]);
        }
        $appointment->load('doctor', 'clinic', 'user');
        return response()->json(['data' => $appointment]);
    }

    public function updateAppointment(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $validatedData = $request->validate([
            'clinic_id' => 'required|integer',
            'doctor_id' => 'required|integer',
            'user_id' => 'required|integer',
            'appointment_date_time' => 'required|date',
            'slot' => 'required|string',
            'details' => 'nullable|string',
        ]);
        $appointment->update($validatedData);
        return response()->json(['message' => 'Appointment updated', 'data' => $appointment]);
    }

    public function destroyAppointment($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();
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
        $appointments = Appointment::with(['doctor', 'clinic', 'user'])
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
                'user' => $appointment->user
            ];
        });

        // Return the appointments as JSON response
        return response()->json(['data' => $formattedAppointments]);
    }
}
