<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::get('/signup', [UserController::class, 'signupForm'])->name('user.signup.get');
Route::post('/signup', [UserController::class, 'signUp'])->name('user.signup');
Route::get('/signin', [UserController::class, 'signin'])->name('user.signin.get');
Route::post('/signin', [UserController::class, 'login'])->name('user.signin.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/verify-otp', [UserController::class, 'verifyOtp'])->name('user.verifyOtp.post'); // Add ".post" to differentiate
Route::get('/verify-otp', [UserController::class, 'showOtpVerification'])->name('user.verifyOtp.get'); // Add ".get" to differentiate

Route::get('/verify-medicare', [UserController::class, 'showMedicareVerification'])->name('user.verifyMedicare.get'); // Add ".get" to differentiate
Route::post('/verify-medicare', [UserController::class, 'verifyMedicare'])->name('user.verifyMedicare.post'); // Add ".get" to differentiate

Route::get('/verify-credit-card', [UserController::class, 'showCreditCardVerification'])->name('user.verifyCreditCard.get'); // Add ".get" to differentiate
Route::post('/verify-credit-card', [UserController::class, 'verifyCreditCard'])->name('user.verifyCreditCard.post'); // Add ".get" to differentiate


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index.get');

Route::get('/appointment', [AppointmentController::class, 'index'])->name('appointment.index.get');
Route::post('/search-clinics-doctors', [AppointmentController::class,'searchClinicsDoctors'])->name('search.clinics.doctors');
Route::get('/booking/{doctorId}', [AppointmentController::class,'questionnaire'])->name('appointment.questionnaire');
Route::post('/questionnaire', [AppointmentController::class,'questionnaireStore'])->name('appointment.questionnaire.store');
Route::get('/schedule', [AppointmentController::class, 'schedule'])->name('appointment.schedule');
Route::post('/scheduleStore', [AppointmentController::class, 'storeAppointment'])->name('appointment.schedule.store');
Route::get('/appointment-landing', [AppointmentController::class, 'getAppointments'])->name('appointment.schedule.list');



