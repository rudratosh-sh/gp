<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

class MeetingController extends Controller
{

    public function createMeeting(Request $request, $meetingId, $role, $appointmentId)
    {
        $en_role = Crypt::encrypt($role);
        $de_role = $role;

        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');

        $existingRoom = Http::get("https://{$METERED_DOMAIN}/api/v1/room/{$meetingId}?secretKey={$METERED_SECRET_KEY}");
        if ($existingRoom->status() != 200) {
            $response = Http::post("https://{$METERED_DOMAIN}/api/v1/room?secretKey={$METERED_SECRET_KEY}", [
                'autoJoin' => true,
                'roomName' => $meetingId
            ]);
            if ($response->status() === 200) {
                return redirect("/" . $de_role . "/validateMeeting/{$meetingId}/{$en_role}/{$appointmentId}");
            } else {
                return redirect()->back()->with('error', 'Meeing Link Expired');
            }
        } else {
            return redirect("/" . $de_role . "/validateMeeting/{$meetingId}/{$en_role}/{$appointmentId}");
        }
    }

    public function validateMeeting(Request $request, $meetingId, $role, $appointmentId)
    {
        $en_role = $role;
        $de_role = Crypt::decrypt($role);
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');

        // Contains logic to validate existing meeting
        $response = Http::get("https://{$METERED_DOMAIN}/api/v1/room/{$meetingId}?secretKey={$METERED_SECRET_KEY}");

        $roomName = $response->json("roomName");
        if ($response->status() === 200) {
            return redirect("/{$de_role}/meeting/{$meetingId}/{$en_role}/{$appointmentId}"); // We will update this soon
        } else {
            return redirect()->back()->with('error', 'Meeing Link Expired! Invalid Meeting ID');
        }
    }

    public function startMeeting(Request $request, $meetingId, $role, $appointmentId)
    {
        $en_role = $role;
        $de_role = Crypt::decrypt($role);
        if (auth()->check()) {
            $user = auth()->user();
        } else {
            abort(Response::HTTP_FORBIDDEN);
        }

        $user = auth()->user();
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $locations = Clinic::with(['bannerImage', 'profileIcon'])->get();
        $doctors = Doctor::with('user')->get();
        $role = Crypt::decrypt($role);

        $appointment = Appointment::where('id', $appointmentId)
            ->first();
        $appointment->load('doctor', 'clinic', 'user', 'medicareDetail', 'meeting');

        //update meeting information
        Meeting::where('meeting_id', $meetingId)->update([
            'start_time' => date('Y-m-d H:i:s')
        ]);
        return view(
            $de_role . '.meeting.start',
            [
                'user' => $user,
                'locations' => $locations,
                'doctors' => $doctors,
                'METERED_DOMAIN' => $METERED_DOMAIN,
                'MEETING_ID' => $meetingId,
                'appointment' => $appointment
            ]
        );
    }
}
