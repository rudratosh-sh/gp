<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Display the sign-up form
    public function signupForm()
    {
        return view('front.users.signup');
    }

    // Handle user registration
    public function signUp(Request $request)
    {
        // Validate the form data
        $request->validate([
            'first_name' => 'required',
            'middle_name' => 'nullable',
            'last_name' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'password' => 'required|min:6',
            'country_code' => 'required', // Validate the country code as well
        ]);

        // Generate a dummy OTP (you can replace this with your actual OTP logic)
        $dummyOtp = '123456';

        // Store user data in session
        $userData = [
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'last_name' => $request->last_name,
            'name' => $request->first_name . ' ' . $request->middle_name . ' ' . $request->last_name,
            'country' => $request->country_code,
            'mobile' => $request->mobile, // Include the country code
            'password' => Hash::make($request->password),
            'role' => 'user',
            'otp' => $dummyOtp, // Store the dummy OTP in the session
            'status' => 0, // Set user status to pending until OTP is verified
        ];

        $request->session()->put('user_data', $userData);

        // Send the OTP to the user (you can implement this)

        // Redirect to the OTP verification page
        return redirect()->route('user.verifyOtp.get'); // Use the .get route for the redirect
    }

    // Display the OTP verification form
    public function showOtpVerification(Request $request)
    {
        $userData = $request->session()->get('user_data');

        if (!$userData) {
            return redirect()->route('user.signup.get')->with('error', 'User data not found.');
        }
        // Calculate the OTP expiration here (you can adjust this logic as needed)
        $otpExpiration = now()->addMinutes(5); // This sets the expiration to 5 minutes from now

        return view('front.users.otp-verification', compact('userData', 'otpExpiration'));
    }

    // Handle OTP verification with a dummy OTP (you can replace this with actual OTP verification logic)
    public function verifyOtp(Request $request)
    {
        $userData = $request->session()->get('user_data');

        if (!$userData) {
            return response()->json(['error' => 'User data not found.'], 400);
        }

        // Get the OTP from the form input
        $enteredOtp = $request->input('otp');

        // Dummy OTP (replace this with your actual OTP logic)
        $dummyOtp = $userData['otp'];

        // Check if the entered OTP matches the stored OTP (dummy OTP check)
        if ($enteredOtp === $dummyOtp) {
            // Create a new user in the database
            $user = User::create($userData);

            // Update user status to 'active' or 'verified'
            $user->status = 1; // Update the status as needed
            $user->save();

            // Log in the user
            Auth::login($user);

            // Clear user data from the session
            $request->session()->forget('user_data');

            // Return a success response with user data
            return response()->json(['success' => 'OTP verification successful.', 'user' => $user], 200);
        } else {
            // OTP is invalid, return an error response
            throw ValidationException::withMessages([
                'otp' => ['Invalid OTP. Please try again.'],
            ]);
        }
    }
    // Handle user login (you can implement this)
    public function login(Request $request)
    {
        // Perform login logic here

        // Redirect or return a response
        return redirect()->back()->with('success', 'Login successful!');
    }

    public function storeUserLocation($user, $latitude, $longitude, $locationName)
    {
        // Create or update the user's location
        $user->location()->updateOrCreate(
            [],
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'location_name' => $locationName,
            ]
        );
    }
}
