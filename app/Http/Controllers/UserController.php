<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Rules\MedicareNumber;
use App\Models\MedicareDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Models\CreditCardInfo;
use App\Rules\CreditCard;
use App\Models\Role;
use Stripe\Stripe;
use Stripe\Charge;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    // Display the sign-up form
    public function signupForm()
    {
        return view('patient.users.signup');
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

        // Create a new user in the database
        $user = User::create($userData);

        // Attach the "patient" role to the user
        $patientRole = Role::where('slug', 'patient')->first();
        $user->customRoles()->attach($patientRole);

        // Update user status to 'active' or 'verified'
        $user->status = 1; // Update the status as needed
        $user->save();

        // Log in the user
        Auth::login($user);

        $userData['user'] = $user;

        $request->session()->put('user_data', $userData);

        // After creating the user in your `signUp` method
        if ($user)
            $user->signupStatus()->create(['basic_details' => true]);

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

        return view('patient.users.otp-verification', compact('userData', 'otpExpiration'));
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
            $user = Auth::user();
            // Authenticating the user via Laravel's Auth system
            Auth::login($user);
            // After OTP verification is successful in `verifyOtp` method
            $user->signupStatus()->update(['otp_verification' => true]);
            // Return a success response with user data
            return response()->json(['success' => 'OTP verification successful.', 'userData' => $userData], 200);
        } else {
            // OTP is invalid, return an error response
            throw ValidationException::withMessages([
                'otp' => ['Invalid OTP. Please try again.'],
            ]);
        }
    }

    // Display the Medicare card verification form
    public function showMedicareVerification(Request $request)
    {
        $userData = $request->session()->get('user_data');

        if (!$userData) {
            return redirect()->route('user.signup.get')->with('error', 'User data not found.');
        }
        return view('patient.users.verify-medicare', compact('userData'));
    }

    public function verifyMedicare(Request $request)
    {
        // merge user id dynamicaly
        if (!$request->has('user_id')) {
            $request->merge(['user_id' => auth()->user()->id]);
        }

        // Fetch user data from the session
        $userData = $request->session()->get('user_data');

        // If user data is not available in the session, get the current authenticated user
        if (!$userData && auth()->check()) {
            $user = auth()->user();
            $userData = [
                'first_name' => $user->first_name,
                'middle_name' => $user->middle_name,
                'last_name' => $user->last_name,
                'name' => $user->name,
                'country' => $user->country_code,
                'mobile' => $user->mobile,
                'password' => $user->password,
                'role' => 'user',
                'otp' => '123456', // Replace with your OTP logic
                'status' => 0,
            ];
        }

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'gender' => 'required|in:Male,Female,Other',
            'birthdate' => 'required|date_format:Y-m-d',
            'Medicare_number' => [
                'required',
                new MedicareNumber, // Apply the MedicareNumber rule
                'unique:medicare_details,Medicare_number',
            ],
            'medicare_image' => 'required|image|mimes:jpeg,png,pdf|max:2048',
            'address' => 'required|string|max:255',
            'user_id' => 'required|unique:medicare_details,user_id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Process the uploaded image
        if ($request->hasFile('medicare_image')) {
            $file = $request->file('medicare_image');

            // Store the uploaded file
            $fileName = 'medicare_card_' . auth()->user()->id . '.' . $file->getClientOriginalExtension();
            $file->storeAs('medicare_cards', $fileName, 'public'); // Change the storage path as needed

            // Create a new MedicareDetail record
            $medicareDetail = new MedicareDetail([
                'gender' => $request->input('gender'),
                'birthdate' => $request->input('birthdate'),
                'medicare_number' => $request->input('Medicare_number'),
                'medicare_image' => $fileName,
                'address' => $request->input('address'),
            ]);

            // Associate it with the current user
            auth()->user()->medicareDetail()->save($medicareDetail);
            // After Medicare card verification is successful in `verifyMedicare` method
            auth()->user()->signupStatus()->update(['medicare_card_verification' => true]);

            return redirect()->route('user.verifyCreditCard.get');
        }

        return redirect()->back()->with('error', 'Failed to upload the Medicare card image.');
    }

    // Display the Medicare card verification form
    public function showCreditCardVerification(Request $request)
    {
        $userData = $request->session()->get('user_data');

        if (!$userData) {
            return redirect()->route('user.signup.get')->with('error', 'User data not found.');
        }
        return view('patient.users.verify-credit-card', compact('userData'));
    }

    public function verifyCreditCard(Request $request)
    {
        // merge user id dynamically
        if (!$request->has('user_id')) {
            $request->merge(['user_id' => auth()->user()->id]);
        }

        // Validation rules
        $rules = [
            'user_id' => 'required|integer', // You can adjust the validation rule as needed
            'card_number' => ['required', new CreditCard], // Assuming you have a custom credit card validation rule
            'expiration_month' => 'required|numeric|min:1|max:12', // Month should be between 1 and 12
            'expiration_year' => 'required|numeric|min:' . date('Y') . '|max:' . (date('Y') + 20), // Year should be this year or later
            'cvv_number' => 'required|digits_between:3,4',
        ];

        // Custom error messages for validation
        $messages = [
            'expiration_year.min' => 'The expiration year cannot be in the past.',
            'expiration_year.max' => 'The expiration year is too far in the future.',
            'expiration_month.min' => 'The expiration month is not valid.',
            'expiration_month.max' => 'The expiration month is not valid.',
        ];

        // Create a validator instance
        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // If validation passes, you can proceed to store the credit card info
        // Be sure to encrypt sensitive data like the card number and CVV before storing

        // Example:
        $creditCardInfo = new CreditCardInfo([
            'user_id' => $request->user_id,
            'card_number' => encrypt($request->card_number), // Encrypt the card number
            'expiration_month' => encrypt($request->expiration_month),
            'expiration_year' => encrypt($request->expiration_year),
            'last_four_digits' => encrypt($request->cvv_number), // Encrypt the CVV
        ]);

        $creditCardInfo->save();
        // After credit card verification is successful in `verifyCreditCard` method
        auth()->user()->signupStatus()->update(['card_details_verification' => true]);
        $user = auth()->user();
        // Authenticating the user via Laravel's Auth system
        Auth::login($user);
        // Redirect to a success page or perform any other necessary actions
        return redirect()->route('dashboard.index.get');
    }


    // Handle user login (you can implement this)
    public function signin(Request $request)
    {
        return view('patient.users.signin');
    }

    // Handle user login (you can implement this)
    public function login(Request $request)
    {
        // Validate the user's input
        $request->validate([
            'mobile_or_email' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            filter_var($request->input('mobile_or_email'), FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile' => $request->input('mobile_or_email'),
            'password' => $request->input('password'),
        ];

        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
            // Retrieve the authenticated user
            $user = Auth::user();
            // Authenticating the user via Laravel's Auth system
            Auth::login($user);
            // Check if the user has completed all steps
            $signupStatus = $user->signupStatus;

            if (!$signupStatus->basic_details) {
                // Redirect to the basic details step
                return redirect()->route('user.signup.get')->with('error', 'Please complete the signup process.');
            } elseif (!$signupStatus->otp_verification) {
                // Redirect to the OTP verification step
                return redirect()->route('user.verifyOtp.get')->with('error', 'Please complete OTP verification.');
            } elseif (!$signupStatus->medicare_card_verification) {
                // Redirect to the Medicare card verification step
                return redirect()->route('user.verifyMedicare.get')->with('error', 'Please complete Medicare card verification.');
            } elseif (!$signupStatus->card_details_verification) {
                // Redirect to the credit card verification step
                return redirect()->route('user.verifyCreditCard.get')->with('error', 'Please complete credit card verification.');
            }

            // Authentication was successful
            return redirect()->route('dashboard.index.get')->with('success', 'Login successful!');
        } else {
            // Authentication failed
            return redirect()->back()->with('error', 'Invalid credentials. Please try again.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('user.signin.get'); // Redirect to the login page after logout
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

    // public function verifyCard(Request $request)
    // {
    //     // Set your Stripe API key
    //     Stripe::setApiKey(config('services.stripe.secret'));

    //     // Collect card details from the form
    //     $cardDetails = [
    //         'number' => '4242424242424242',
    //         'exp_month' => '09',
    //         'exp_year' => '2024',
    //         'cvc' => '342',
    //     ];

    //     Stripe::setApiKey('sk_test_51NuItUKowBPdmLR1YEmIsqgVaut4Up6J5ANg7LfBLRFwF4hkSZIZJZkZPGhPOonSKL2HMc9BMBy6nwGx3Y05y2pC00hwvzcu5S');
    //     $token = 'tok_visa';
    //     try {
    //         // Create a test charge to verify the card
    //        $s =  Charge::create([
    //             'amount' => 1,  // $1.00
    //             'currency' => 'inr',
    //             'source' => $token,
    //         ]);

    //         dd($s);
    //         // Card is verified, proceed accordingly
    //         return redirect()->back()->with('success', 'Card verified successfully');
    //     } catch (\Exception $e) {
    //         // Card verification failed
    //         return redirect()->back()->with('error', 'Card verification failed: ' . $e->getMessage());
    //     }
    // }
}
