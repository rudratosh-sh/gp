<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Response;

class VideoCallController extends Controller
{

    public function index(Request $request)
    {
        return  view('video-call');
    }

    public function handleSignal(Request $request)
    {
        // Retrieve signaling data from the request
        $data = $request->all();

        // Authenticate and validate the request, e.g., check user authentication

        // Broadcast signaling data to Pusher channel
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ]
        );

        // Broadcast the signaling data to a specific channel (or multiple channels)
        $pusher->trigger('video-call-channel', 'signal-event', $data);

        // Optionally, you can return a success response
        return response()->json(['message' => 'Signaling data broadcasted successfully']);
    }

    public function subscribeChannel(Request $request)
    {
        $app_key = '1a96c62d17b6395fe814';
        $app_secret = 'ed37a3cb09cf70821d68';
        $app_id = '1712697';
        $app_cluster = 'ap4';

        $pusher = new Pusher($app_key, $app_secret, $app_id, [
            'cluster' => $app_cluster,
        ]);

        $socket_id = $request->input('socket_id');
        $channel_name = $request->input('channel_name');

        // Authenticate private channel
        $auth = $pusher->authorizeChannel($channel_name, $socket_id);
        // OR authenticate presence channel
        // $user_id = 'USER_ID';
        // $user_info = ['name' => 'User Name']; // Replace with actual user info
        // $auth = $pusher->authorizePresenceChannel($channel_name, $socket_id, $user_id, $user_info);

        return $auth;
    }

    public function handleOfferAnswer(Request $request)
    {
        $data = $request->all();

        // Get the offer from the request data
        $offer = $data['offer'];

        // Assuming you have a WebRTC library instance stored somewhere
        $yourWebRTCInstance = $this->getYourWebRTCInstance(); // Retrieve your WebRTC instance

        // Set the remote description using the offer
        $yourWebRTCInstance->setRemoteDescription($offer);

        // Create an answer
        $answer = $yourWebRTCInstance->createAnswer();

        // Set the local description with the created answer
        $yourWebRTCInstance->setLocalDescription($answer);

        return response()->json(['success' => true]);
    }

    public function handleICECandidate(Request $request)
    {
        $data = $request->all();

        // Get ICE candidate from the request data
        $iceCandidate = $data['candidate'];

        // Assuming you have a WebRTC library instance stored somewhere
        $yourWebRTCInstance = $this->getYourWebRTCInstance(); // Retrieve your WebRTC instance

        // Add the ICE candidate to the WebRTC connection
        $yourWebRTCInstance->addICECandidate($iceCandidate);

        return response()->json(['success' => true]);
    }

}
