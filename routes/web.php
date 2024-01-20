<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppointmentController;
use App\Events\NotificationEvent;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\MeetingController;
use App\Models\Meeting;

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

/**Auth Routes */
Route::get('/patient/signup', [PatientController::class, 'signupForm'])->name('user.signup.get');
Route::post('/patient/signup', [PatientController::class, 'signUp'])->name('user.signup');
Route::get('/patient/signin', [PatientController::class, 'signin'])->name('user.signin.get');
Route::post('/patient/signin', [PatientController::class, 'login'])->name('user.signin.post');

Route::get('/doctor/signin', [DoctorController::class, 'signin'])->name('doctor.signin.get');
Route::post('/doctor/signin', [DoctorController::class, 'signInProcess'])->name('doctor.signin.post');

Route::get('/staff/signin', [StaffController::class, 'signin'])->name('staff.signin.get');
Route::post('/staff/signin', [StaffController::class, 'signInProcess'])->name('staff.signin.post');

Route::get('/logout', [PatientController::class, 'logout'])->name('logout');

// /**Patient**/
Route::middleware(['check.user.role:patient'])->group(function () {

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
    Route::get('/patient/booking/{doctorId}/{bookingType}', [AppointmentController::class, 'Book a Visit'])->name('appointment.questionnaire');
    Route::post('/patient/questionnaire/{bookingType}', [AppointmentController::class, 'questionnaireStore'])->name('appointment.questionnaire.store');
    Route::get('/patient/schedule', [AppointmentController::class, 'schedule'])->name('appointment.schedule');
    Route::post('/patient/scheduleStore', [AppointmentController::class, 'storeAppointment'])->name('appointment.schedule.store');
    Route::get('/patient/appointment-landing', [AppointmentController::class, 'getAppointments'])->name('appointment.schedule.list');

    Route::get('/messages/{conversationId}', [MessageController::class, 'getMessages'])->name('messages.getMessages');
    // Route to fetch all threads
    Route::get('/threads', [MessageController::class, 'getThreads'])->name('messages.getThreads');
    // Route to fetch a conversation with a specific user
    Route::get('/conversation/{userId}', [MessageController::class, 'getConversation'])->name('messages.getConversation');
    Route::post('/messages/send', [MessageController::class, 'sendMessage'])->name('messages.send');
    Route::post('/messages/mark-as-read', [MessageController::class, 'markAsRead'])->name('messages.markAsRead');

    Route::get('/patient/referal', [PatientController::class, 'getReferal'])->name('referal.index.get');

    Route::get("/patient/createMeeting/{meetingId}/{role}", [MeetingController::class, 'createMeeting'])->name('meeting.create.get');
    Route::get("/patient/meeting/{meetingId}/{role}", [MeetingController::class, 'startMeeting'])->name('meeting.start.get');
    Route::get("/patient/validateMeeting/{meetingId}/{role}", [MeetingController::class, 'validateMeeting'])->name("meeting.validate.get");

/**Doctor**/
Route::middleware(['check.user.role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard.get');
    Route::get('/doctor/getAppointments', [DoctorController::class, 'getAppointments'])->name('doctor.appointments.get');
    Route::post('/pusher/auth', [MessageController::class, 'authenticatePusherChannel']);

    Route::get('/doctor', [DoctorController::class, 'dashboard'])->name('doctor.index');
    Route::get('/doctor/history', [DoctorController::class, 'history'])->name('doctor.history.index');

    Route::get('/doctor/getHistory', [DoctorController::class, 'getHistory'])->name('doctor.history.get');
    Route::get('/doctor/patientDetails/{userId}', [DoctorController::class, 'getPatientDetails'])->name('doctor.patient.details.get');

    Route::get('/doctor/createNote/{userId}', [DoctorController::class, 'createNote'])->name('doctor.create.note.get');
    Route::post('/doctor/createNotePost', [DoctorController::class, 'createNotePost'])->name('doctor.create.note.post');

    Route::get('/doctor/createOtherInfo/{userId}', [DoctorController::class, 'createOtherInfo'])->name('doctor.create.other-info.get');
    Route::post('/doctor/createOtherInfoPost', [DoctorController::class, 'createOtherInfoPost'])->name('doctor.create.other-info.post');

    Route::get('/doctor/createRefLetter/{userId}', [DoctorController::class, 'createRefLetter'])->name('doctor.create.ref-letter.get');
    Route::post('/doctor/createRefLetterPost', [DoctorController::class, 'createRefLetterPost'])->name('doctor.create.ref-letter.post');

    Route::get('/doctor/createPrescription/{userId}', [DoctorController::class, 'createPrescription'])->name('doctor.create.prescription.get');
    Route::post('/doctor/createPrescriptionPost', [DoctorController::class, 'createPrescriptionPost'])->name('doctor.create.prescription.post');
    Route::get('/medications/search', [DoctorController::class, 'searchMedications'])->name('medication.autocomplete');
    Route::get('/routes/search', [DoctorController::class, 'searchRoutes'])->name('route.autocomplete');

    Route::get('/doctor/profile', [DoctorController::class, 'profile'])->name('doctor.profile.get');
    Route::post('/doctor/profile/update', [DoctorController::class, 'profileUpdate'])->name('doctor.profile.update');

    Route::get("/doctor/createMeeting/{meetingId}/{role}", [MeetingController::class, 'createMeeting'])->name('meeting.create.get');
    Route::get("/doctor/meeting/{meetingId}/{role}", [MeetingController::class, 'startMeeting'])->name('meeting.start.get');
    Route::get("/doctor/validateMeeting/{meetingId}/{role}", [MeetingController::class, 'validateMeeting'])->name("meeting.validate.get");
});

/**Staff**/
Route::middleware(['check.user.role:staff'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard.get');
    Route::get('/staff/getAppointments', [StaffController::class, 'getAppointments'])->name('staff.appointments.get');
    Route::post('/pusher/auth', [MessageController::class, 'authenticatePusherChannel']);
    Route::get('/staff', [StaffController::class, 'dashboard'])->name('staff.index');
    Route::get('/staff/{userId}/vitals', [StaffController::class, 'showPatientVitals'])->name('staff.patient.vitals');
    Route::post('/staff/save-patient-vitals/{userId}', [StaffController::class, 'savePatientVitals'])->name('staff.save.patient.vitals');
    Route::get('/staff/profile', [StaffController::class, 'profile'])->name('staff.profile.get');
    Route::post('/staff/profile/update', [StaffController::class, 'profileUpdate'])->name('staff.profile.update');
});


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

Route::post('/speech-to-text', [PatientController::class, 'convertSpeechToText']);

Route::get('/video', [VideoCallController::class, 'index'])->name('video');
Route::post('/signal', [VideoCallController::class, 'handleSignal'])->name('signal');
Route::post('/subscribe-channel', [VideoCallController::class, 'subscribeChannel'])->name('subscribe-channel');
Route::post('/offer-answer', 'VideoCallController@handleOfferAnswer')->name('offer-answer');
Route::post('/ice-candidate', 'VideoCallController@handleICECandidate')->name('ice-candidate');

// Route::post("/createMeeting", [MeetingController::class, 'createMeeting'])->name("createMeeting");

// Route::post("/validateMeeting", [MeetingController::class, 'validateMeeting'])->name("validateMeeting");

// Route::get("/meeting/{meetingId}", function ($meetingId) {

//     $METERED_DOMAIN = env('METERED_DOMAIN');
//     return view('meeting', [
//         'METERED_DOMAIN' => $METERED_DOMAIN,
//         'MEETING_ID' => $meetingId
//     ]);
// });

// Route::get('/video-start', function () {
//     return view('video-start');
});
