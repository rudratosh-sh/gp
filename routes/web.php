<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
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

    Route::get('/patient/signup', [UserController::class, 'signupForm'])->name('user.signup.get');
    Route::post('/patient/signup', [UserController::class, 'signUp'])->name('user.signup');
    Route::get('/patient/signin', [UserController::class, 'signin'])->name('user.signin.get');
    Route::post('/patient/signin', [UserController::class, 'login'])->name('user.signin.post');
    Route::get('/patient/logout', [UserController::class, 'logout'])->name('logout');

    Route::post('/patient/verify-otp', [UserController::class, 'verifyOtp'])->name('user.verifyOtp.post'); // Add ".post" to differentiate
    Route::get('/patient/verify-otp', [UserController::class, 'showOtpVerification'])->name('user.verifyOtp.get'); // Add ".get" to differentiate

    Route::get('/patient/verify-medicare', [UserController::class, 'showMedicareVerification'])->name('user.verifyMedicare.get'); // Add ".get" to differentiate
    Route::post('/patient/verify-medicare', [UserController::class, 'verifyMedicare'])->name('user.verifyMedicare.post'); // Add ".get" to differentiate

    Route::get('/patient/verify-credit-card', [UserController::class, 'showCreditCardVerification'])->name('user.verifyCreditCard.get'); // Add ".get" to differentiate
    Route::post('/patient/verify-credit-card', [UserController::class, 'verifyCreditCard'])->name('user.verifyCreditCard.post'); // Add ".get" to differentiate


    Route::get('/patient/dashboard', [DashboardController::class, 'index'])->name('dashboard.index.get');

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
