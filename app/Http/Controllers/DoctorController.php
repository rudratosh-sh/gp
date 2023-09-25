<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function signin(Request $request)
    {
        return view('front.doctors.signin');
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

        $credentials = $request->only('email', 'password','mobile');

        $user = User::where(function ($query) use ($credentials) {
            $query->where('email', $credentials['email'])
                ->where('mobile', $credentials['mobile']);
        })
            ->whereHas('roles', function ($query) {
                $query->where('name', 'doctor'); // Check for the "doctor" role
            })
            ->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            // Invalid credentials, redirect back to login page
            return redirect()->route('doctor.signin.get')->with('error', 'Invalid login credentials.');
        }

        // Authentication successful, store user data in session
        $request->session()->put('user', $user);

        // Redirect to the doctor's dashboard or any desired route
        return redirect()->route('doctor.dashboard');
    }
}
