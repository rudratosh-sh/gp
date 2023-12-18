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
use App\Models\Staff;
use Pusher\Pusher;
use App\Models\VitalsMaster;
use App\Models\ClinicVitals;
use App\Models\PatientVitalsValues;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class StaffController extends Controller
{
    public function signin(Request $request)
    {
        // Auth::logout();
        return view('staff.users.signin');
    }

    public function signInProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required_without:mobile', 'email'],
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff.signin.get')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $user = User::where(function ($query) use ($credentials) {
            $query->where('email', $credentials['email']);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'staff'); // Check for the "staff" role
            })
            ->with('staff.clinic') // Eager load the staff and clinic relationships
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Invalid credentials, redirect back to login page
            Toast::info(__('Invalid login credentials.'));
            return redirect()->route('staff.signin.get')->with('error', 'Invalid login credentials.');
        }
        // Authenticating the user via Laravel's Auth system
        Auth::login($user);
        // Authentication successful, store user data in session
        $request->session()->put('staff', $user);

        // Redirect to the staff's dashboard or any desired route
        return redirect()->route('staff.dashboard.get');
    }

    public function dashboard(Request $request)
    {
        // Retrieve the 'staff' variable from the session
        $user = $request->session()->get('staff');
        $staff = Staff::where('user_id', $user->id)
            ->with(['clinic']) // Load banner image and profile icon relationships
            ->first();

        // Get a list of all appointments
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', date('Y-m-d'))
            ->whereHas('clinic', function ($query) use ($staff) {
                $query->where('clinic_id', $staff->clinic_id); // Assuming there's a user_id in the clinics table
            })
            ->where('clinic_id', $staff->clinic_id)
            ->get();

        // Load related data (e.g., staff and clinic details) if necessary
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');

        if (auth()->check()) {
            // If authenticated, retrieve the authenticated user's data
            $user = auth()->user();
        } else {
            // If not authenticated, return a 404 error
            abort(Response::HTTP_FORBIDDEN);
        }

        return view('staff.pages.booked-appointment', ['user' => $staff, 'appointments' => $appointments]);
    }

    public function getAppointments(Request $request)
    {
        $selectedDate = $request->input('selectedDate');

        $staff = Staff::where('user_id', auth()->id())
            ->with(['clinic']) // Load banner image and profile icon relationships
            ->first();

        // Log the selected date
        Log::info('Selected Date: ' . $selectedDate . 'id' . auth()->id() . 'clinic id ' . $staff->clinic_id);

        // Retrieve appointments based on the date part of the appointment_date_time
        $appointments = Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->whereHas('clinic', function ($query) use ($staff) {
                $query->where('clinic_id', $staff->clinic_id); // Assuming there's a user_id in the clinics table
            })
            ->where('clinic_id', $staff->clinic_id)
            ->get();

        // Log the generated SQL query for the appointments
        Log::info('Generated Appointments Query: ' . Appointment::where(DB::raw('DATE(appointment_date_time)'), '=', $selectedDate)
            ->whereHas('clinic', function ($query) use ($staff) {
                $query->where('clinic_id', $staff->clinic_id);
            })
            ->where('clinic_id', $staff->clinic_id)
            ->toSql());

        // Load related data if necessary
        $appointments->load('doctor', 'clinic', 'user', 'medicareDetail');

        // Transform appointments to include encrypted_user_id
        $transformedAppointments = $appointments->map(function ($appointment) {
            $appointment['encrypted_user_id'] = encrypt($appointment->user_id);
            return $appointment;
        });

        // Return the transformed appointments as JSON
        return response()->json(['appointments' => $transformedAppointments]);
    }


    public function showPatientVitals($userId)
    {
        $userId = Crypt::decrypt($userId);

        $staff = Staff::where('user_id', auth()->id())->first();

        if ($staff && $staff->clinic_id) {
            $user = User::findOrFail($userId);
            $user->load('medicareDetail');

            $appointment = Appointment::where('user_id', $user->id)
                ->where('clinic_id', $staff->clinic_id)
                ->first();

            if ($appointment) {

                $vitalMaster = ClinicVitals::where('clinic_id', $staff->clinic_id)
                    ->with('vital')
                    ->get();

                $paitentVital = PatientVitalsValues::where('user_id', $userId)
                    ->with('clinicVital.vital')
                    ->get();

                return view('staff.pages.vitals', [
                    'user' => $staff,
                    'patient' => $user,
                    'clinicVitals' => $paitentVital,
                    'vitalMaster' => $vitalMaster,
                    'last_visited' => $appointment->last_visited
                ]);
            }
        }
        abort(404);
    }

    public function savePatientVitals(Request $request, $userId)
    {
        try {
            // Handle form data
            $requestData = $request->except('_token'); // Exclude token from form data
            $encryptedClinicId = $request->input('clinic_id'); // Get encrypted clinic ID from the request
            $clinicId = Crypt::decrypt($encryptedClinicId); // Decrypt clinic ID
            $decryptedUserId = Crypt::decrypt($userId); // Decrypt user ID
            // Get clinic vitals for the specific clinic
            $clinicVitals = ClinicVitals::where('clinic_id', $clinicId)->with('vital')->get();

            // Update patient's vitals (Update or insert into PatientVitalsValues table)
            foreach ($clinicVitals as $clinicVital) {
                $clinicVitalId = $clinicVital->id;
                $value = $requestData['vitals'][$clinicVitalId] ?? null;

                if ($clinicVital->vital->type === 'upload' && $request->hasFile('vital_uploads_' . $clinicVitalId)) {
                    // Validate file here (size, type) before storing
                    $validatedData = $request->validate([
                        'vital_uploads_' . $clinicVitalId => 'required|mimes:jpeg,png,doc,docx,pdf|max:50000',
                    ]);

                    $randomString = Str::random(10); // Generate a random string of 10 characters
                    $file = $request->file('vital_uploads_' . $clinicVitalId);
                    $fileName = 'vital_' . $clinicVitalId . '_' . $decryptedUserId . '_' . $randomString . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('vital_uploads', $fileName, 'public');

                    // Update or insert file details into the database
                    PatientVitalsValues::updateOrCreate(
                        ['user_id' => $decryptedUserId, 'clinic_vital_id' => $clinicVitalId],
                        ['value' => '/storage/vital_uploads/'.$fileName] // Save file name or details in the 'value' field
                    );
                } elseif ($clinicVital->vital->type === 'upload' && $request->hasFile('vitals') && isset($requestData['vitals'][$clinicVitalId])) {
                    // Validate file here (size, type) before storing
                    $validatedData = $request->validate([
                        'vitals.' . $clinicVitalId => 'required|mimes:jpeg,png,doc,docx,pdf|max:50000',
                    ]);

                    $randomString = Str::random(10); // Generate a random string of 10 characters
                    $file = $request->file('vitals')[$clinicVitalId];
                    $fileName = 'vital_' . $clinicVitalId . '_' . $decryptedUserId . '_' . $randomString . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('vital_uploads', $fileName, 'public');

                    // Update or insert file details into the database
                    PatientVitalsValues::updateOrCreate(
                        ['user_id' => $decryptedUserId, 'clinic_vital_id' => $clinicVitalId],
                        ['value' => '/storage/vital_uploads/'.$fileName] // Save file name or details in the 'value' field
                    );
                } else {
                    // Handle regular text data for non-upload vitals
                    if ($value !== null && $clinicVital->vital->type !== 'upload') {
                        PatientVitalsValues::updateOrCreate(
                            ['user_id' => $decryptedUserId, 'clinic_vital_id' => $clinicVitalId],
                            ['value' => $value]
                        );
                    }
                }
            }

            // Redirect or return a response accordingly
            return redirect()->back()->with('success', 'Vitals saved successfully');
        } catch (ValidationException $e) {
            // Handle validation errors here
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    // Display patient profile
    public function profile()
    {
        $currentUser = Auth::user();
        $profileData = User::where('id', $currentUser->id)->first();
        $user = Staff::where('user_id', auth()->id())->first();
        $fields = ['name', 'about_me', 'email', 'mobile'];

        return view('staff.pages.profile', compact('profileData', 'fields','user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'about_me' => 'nullable|string|max:1000',
            'email' => 'required|string|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|max:2048', // Adjust max file size as needed
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $randomName = Str::random(20);
            $avatarPath = $avatar->storeAs('avatars', $randomName . '.' . $avatar->getClientOriginalExtension(), 'public');

            // Save the public path in the database
            $user->avatar = '/storage/' . $avatarPath;
            $user->save();

            unset($validatedData['avatar']);
        }

        // Update user profile data
        $user->update($validatedData);

        return redirect()->route('staff.profile.get')->with('success', 'Profile updated successfully.');
    }
}
