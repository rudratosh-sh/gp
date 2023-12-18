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
use App\Models\Note;
use App\Models\Attachment;
use App\Models\OtherInfo;
use App\Models\ReferralLetter;

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

    public function getPatientDetails(Request $request, $userId)
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
        return view('doctor.pages.patient-details', ['user' => $doctor, 'appointment' => $appointment]);
    }

    public function createNote(Request $request, $userId)
    {
        $userId = Crypt::decrypt($userId);
        $doctor = $request->session()->get('doctor');
        $appointment = Appointment::where('user_id', $userId)
            ->first();

        $appointment->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues', 'notes');

        if ($appointment->notes !== null && $appointment->notes->attachments != null) {
            $attachmentIds = json_decode($appointment->notes->attachments, true);

            $attachments = Attachment::whereIn('id', $attachmentIds)->get();
        } else {
            $attachments = collect();
        }

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.create-note', ['user' => $doctor, 'appointment' => $appointment, 'attachments' => $attachments]);
    }

    public function createNotePost(Request $request)
    {
        $userId = decrypt($request->input('note_user_id'));
        $clinicId = decrypt($request->input('note_clinic_id'));
        $doctorId = decrypt($request->input('note_doctor_id'));

        $data = $request->except(['note_user_id', 'note_clinic_id', 'note_doctor_id']);
        $data['user_id'] = $userId;
        $data['clinic_id'] = $clinicId;
        $data['doctor_id'] = $doctorId;

        $note = Note::updateOrCreate(
            [
                'user_id' => $userId,
                'clinic_id' => $clinicId,
                'doctor_id' => $doctorId,
            ],
            $data
        );
        try {
            $attachmentIds = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store('attachments');

                    $attachmentData = [
                        'name' => $attachment->getClientOriginalName(),
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                        'extension' => $attachment->getClientOriginalExtension(),
                        'size' => $attachment->getSize(),
                        'sort' => 0,
                        'path' => $path,
                        'description' => '',
                        'alt' => '',
                        'hash' => '',
                        'disk' => 'public',
                        'user_id' => $userId,
                        'group' => '',
                    ];
                    $attachment = Attachment::create($attachmentData);
                    $attachmentIds[] = $attachment->id; // Collect attachment IDs
                }
            }
            if (count($attachmentIds) > 0)
                Note::where('id', $note->id)->update([
                    'attachments' => json_encode($attachmentIds),
                ]);

            $message = $note->wasRecentlyCreated ? 'Note created successfully.' : 'Note updated successfully.';
            return back()->with('success', $message);
        } catch (\Exception $e) {
            // Log or handle the exception
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->with('error', 'An error occurred during file upload.');
        }
        $message = $note->wasRecentlyCreated ? 'Note created successfully.' : 'Note updated successfully.';
        return back()->with('success', $message);
    }


    public function createOtherInfo(Request $request, $userId)
    {
        $userId = Crypt::decrypt($userId);
        $doctor = $request->session()->get('doctor');
        $appointment = Appointment::where('user_id', $userId)
            ->first();

        $appointment->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues', 'otherInfo');
        if ($appointment->otherInfo !== null && $appointment->otherInfo->attachments != null) {
            $attachmentIds = json_decode($appointment->otherInfo->attachments, true);
            $attachments = Attachment::whereIn('id', $attachmentIds)->get();
        } else {
            $attachments = collect();
        }

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.create-other-info', ['user' => $doctor, 'appointment' => $appointment, 'attachments' => $attachments]);
    }

    public function createOtherInfoPost(Request $request)
    {
        $userId = decrypt($request->input('other_user_id'));
        $clinicId = decrypt($request->input('other_clinic_id'));
        $doctorId = decrypt($request->input('other_doctor_id'));

        $data = $request->except(['other_user_id', 'other_clinic_id', 'other_doctor_id']);
        $data['user_id'] = $userId;
        $data['clinic_id'] = $clinicId;
        $data['doctor_id'] = $doctorId;

        $otherInfo = OtherInfo::updateOrCreate(
            [
                'user_id' => $userId,
                'clinic_id' => $clinicId,
                'doctor_id' => $doctorId,
            ],
            $data
        );
        try {
            $attachmentIds = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store('attachments');

                    $attachmentData = [
                        'name' => $attachment->getClientOriginalName(),
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                        'extension' => $attachment->getClientOriginalExtension(),
                        'size' => $attachment->getSize(),
                        'sort' => 0,
                        'path' => $path,
                        'description' => '',
                        'alt' => '',
                        'hash' => '',
                        'disk' => 'public',
                        'user_id' => $userId,
                        'group' => '',
                    ];
                    $attachment = Attachment::create($attachmentData);
                    $attachmentIds[] = $attachment->id; // Collect attachment IDs
                }
            }
            if (count($attachmentIds) > 0)
                OtherInfo::where('id', $otherInfo->id)->update([
                    'attachments' => json_encode($attachmentIds),
                ]);

            $message = $otherInfo->wasRecentlyCreated ? 'Other Info created successfully.' : 'Other Info updated successfully.';
            return back()->with('success', $message);
        } catch (\Exception $e) {
            // Log or handle the exception
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->with('error', 'An error occurred during file upload.');
        }
        $message = $otherInfo->wasRecentlyCreated ? 'Other Info created successfully.' : 'Other Info updated successfully.';
        return back()->with('success', $message);
    }

    public function createRefLetter(Request $request, $userId)
    {
        $userId = Crypt::decrypt($userId);
        $doctor = $request->session()->get('doctor');
        $appointment = Appointment::where('user_id', $userId)
            ->first();

        $appointment->load('doctor', 'clinic', 'user', 'medicareDetail', 'patientVitalValues', 'refLetter');

        if ($appointment->refLetter !== null && $appointment->refLetter->attachments !== null) {
            $attachmentIds = json_decode($appointment->refLetter->attachments, true);
            $attachments = Attachment::whereIn('id', $attachmentIds)->get();
        } else {
            $attachments = collect(); // or null or any other default value you prefer
        }

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }
        return view('doctor.pages.create-referral-letter', ['user' => $doctor, 'appointment' => $appointment, 'attachments' => $attachments]);
    }

    public function createRefLetterPost(Request $request)
    {
        $userId = decrypt($request->input('ref_user_id'));
        $clinicId = decrypt($request->input('ref_clinic_id'));
        $doctorId = decrypt($request->input('ref_doctor_id'));

        $data = $request->except(['ref_user_id', 'ref_clinic_id', 'ref_doctor_id']);
        $data['user_id'] = $userId;
        $data['clinic_id'] = $clinicId;
        $data['doctor_id'] = $doctorId;

        $refLetter = ReferralLetter::updateOrCreate(
            [
                'user_id' => $userId,
                'clinic_id' => $clinicId,
                'doctor_id' => $doctorId,
            ],
            $data
        );
        try {
            $attachmentIds = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $attachment) {
                    $path = $attachment->store('attachments');

                    $attachmentData = [
                        'name' => $attachment->getClientOriginalName(),
                        'original_name' => $attachment->getClientOriginalName(),
                        'mime' => $attachment->getClientMimeType(),
                        'extension' => $attachment->getClientOriginalExtension(),
                        'size' => $attachment->getSize(),
                        'sort' => 0,
                        'path' => $path,
                        'description' => '',
                        'alt' => '',
                        'hash' => '',
                        'disk' => 'public',
                        'user_id' => $userId,
                        'group' => '',
                    ];
                    $attachment = Attachment::create($attachmentData);
                    $attachmentIds[] = $attachment->id; // Collect attachment IDs
                }
            }
            if (count($attachmentIds) > 0)
                ReferralLetter::where('id', $refLetter->id)->update([
                    'attachments' => json_encode($attachmentIds),
                ]);

            $message = $refLetter->wasRecentlyCreated ? 'Referral Letter created successfully.' : 'Referral Letter updated successfully.';
            return back()->with('success', $message);
        } catch (\Exception $e) {
            // Log or handle the exception
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return back()->with('error', 'An error occurred during file upload.');
        }
        $message = $refLetter->wasRecentlyCreated ? 'Referral Letter created successfully.' : 'Referral Letter updated successfully.';
        return back()->with('success', $message);
    }
}
