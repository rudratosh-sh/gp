<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Events\NotificationEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// /**Patient**/
// Route::middleware(['check.user.role:patient'])->group(function () {

    Route::get('/patient/signup', [PatientController::class, 'signupForm'])->name('user.signup.get');
    Route::post('/patient/signup', [PatientController::class, 'signUp'])->name('user.signup');
    Route::get('/patient/signin', [PatientController::class, 'signin'])->name('user.signin.get');
    Route::post('/patient/signin', [PatientController::class, 'login'])->name('user.signin.post');
    Route::get('/patient/logout', [PatientController::class, 'logout'])->name('logout');

    Route::post('/patient/verify-otp', [PatientController::class, 'verifyOtp'])->name('user.verifyOtp.post'); // Add ".post" to differentiate
    Route::get('/patient/verify-otp', [PatientController::class, 'showOtpVerification'])->name('user.verifyOtp.get'); // Add ".get" to differentiate

    Route::get('/patient/verify-medicare', [PatientController::class, 'showMedicareVerification'])->name('user.verifyMedicare.get'); // Add ".get" to differentiate
    Route::post('/patient/verify-medicare', [PatientController::class, 'verifyMedicare'])->name('user.verifyMedicare.post'); // Add ".get" to differentiate

    Route::get('/patient/verify-credit-card', [PatientController::class, 'showCreditCardVerification'])->name('user.verifyCreditCard.get'); // Add ".get" to differentiate
    Route::post('/patient/verify-credit-card', [PatientController::class, 'verifyCreditCard'])->name('user.verifyCreditCard.post'); // Add ".get" to differentiate

    Route::get('/patient/profile', [PatientController::class, 'profile'])->name('patient.profile.get');
    Route::post('/patient/profile/update', [PatientController::class, 'profileUpdate'])->name('patient.profile.update');


    Route::get('/patient/dashboard', [DashboardController::class, 'index'])->name('dashboard.index.get');
    Route::get('/patient', [AppointmentController::class, 'getAppointments'])->name('appointment.patient');
    Route::get('/patient/appointment', [AppointmentController::class, 'index'])->name('appointment.index.get');
    Route::post('/patient/search-clinics-doctors', [AppointmentController::class, 'searchClinicsDoctors'])->name('search.clinics.doctors');
    Route::get('/patient/booking/{doctorId}', [AppointmentController::class, 'questionnaire'])->name('appointment.questionnaire');
    Route::post('/patient/questionnaire', [AppointmentController::class, 'questionnaireStore'])->name('appointment.questionnaire.store');
    Route::get('/patient/schedule', [AppointmentController::class, 'schedule'])->name('appointment.schedule');
    Route::post('/patient/scheduleStore', [AppointmentController::class, 'storeAppointment'])->name('appointment.schedule.store');
    Route::get('/patient/appointment-landing', [AppointmentController::class, 'getAppointments'])->name('appointment.schedule.list');
// });


/**Doctor**/
// Route::middleware(['check.user.role:doctor'])->group(function () {

    Route::get('/doctor/staff-signin', [DoctorController::class, 'signin'])->name('doctor.signin.get');
    Route::post('/doctor/staff-signin', [DoctorController::class, 'signInProcess'])->name('doctor.signin.post');

    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard.get');
    Route::get('/doctor/getAppointments', [DoctorController::class, 'getAppointments'])->name('doctor.appointments.get');


// });
Route::get('/send-notification', function () {
    $title = 'Test Notification Title';
    $message = 'This is a test notification message.';

    event(new NotificationEvent($title, $message));

    return "Notification sent: $title - $message";
});

Route::get('/test-google-credentials', function () {
    $credentialsPath = env('GOOGLE_APPLICATION_CREDENTIALS');

    return "Google Cloud credentials path: $credentialsPath";
});

Route::get('/speech-to-text', [PatientController::class, 'convertSpeechToText']);

