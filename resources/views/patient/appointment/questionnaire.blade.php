@extends('patient.layouts.public')

@section('content')
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')

        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li class="tab-option" id="dashboard-tab">Dashboard</li>
                <li class="tab-option active" id="booking-tab">Booking Appointment</li>
                <li class="tab-option" id="referral-tab">Referral Letter</li>
                <li class="tab-option" id="profile-tab">My Profile</li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx">
                <form id="scheduleForm" method="POST" action="{{ route('appointment.questionnaire.store', ['bookingType' => $bookingType]) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="booking_container">
                        <h1 class="booking_title">Booking Appointment</h1>
                        <div class="clinic_counter">
                            <div class="tabs">
                                <div class="tab">
                                    <div class="dis_flx_center">
                                        <div class="tab_circle">
                                            <span class="step-count">1</span>
                                        </div>
                                        <a href="#" class="tab_title">Select Clinic</a>
                                    </div>
                                </div>
                                <div class="tab active">
                                    <div class="dis_flx_center">
                                        <div class="tab_circle">
                                            <span class="step-count">2</span>
                                        </div>
                                        <a class="tab_title" href="page6.html"> Questionnaire </a>
                                    </div>
                                </div>
                                <div class="tab">
                                    <div class="dis_flx_center">
                                        <div class="tab_circle">
                                            <span class="step-count">3</span>
                                        </div>
                                        <a class="tab_title" href="page7.html">Schedule</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="book_call_container">
                            <div class="doc_details_pg6">
                                <div class="card_pg6">
                                    <div class="left-section_pg6">
                                        <div class="small-image_pg6"></div>
                                        <div class="doc_detail_pg6">
                                            <h2 class="title_pg6">{{ $doctor->name }}</h2>
                                            <p class="click-name_pg6">{{ $doctor->clinic->name }}</p>
                                            <div class="flx_space_btw">
                                                <p class="direction_pg6">{{ $doctor->clinic->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="center_section_pg6">
                                        <div class="center_content_pg6">
                                            <h2 class="title_pg6">{{ $doctor->name }}</h2>
                                            <div class="flx_space_btw dis_center_pg6">
                                                <p class="direction_pg6">{{ $doctor->clinic->location }}</p>
                                                <p class="direction_pg6">7km</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right_section_pg6">
                                        <div class="btn_booking_pg6">
                                            <span class="btn_bt_pg6">Booking Video Call Consultation</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Replace the following sections with dynamic data -->
                        <!-- You can use Blade directives to loop through data and display it -->
                        <input type="hidden" name="doctor_id" value="{{ $doctor->user_id }}">
                        <div class="question_container_pg6">
                            @foreach ($questions as $question)
                                <div id="question_{{ $question->id }}" class="asking_problem">
                                    <h1 class="light_txt_pg6">{{ $question->question_text }}</h1>
                                    <div class="speak_txt_content_pg6">
                                        @if ($question->input_type === 'text')
                                            <input type="text" name="answers[{{ $question->id }}]" class="user_txt_pg6"
                                                id="answer_{{ $question->id }}">
                                            <img src="{{ asset('/assets/mic.png') }}" alt=""
                                                onclick="toggleRecording({{ $question->id }})"
                                                id="mic_{{ $question->id }}">
                                        @elseif ($question->input_type === 'file')
                                            <label for="uploadFile_{{ $question->id }}" class="upload_photo_pg6">
                                                <span>Upload Photo</span>
                                                <input type="file" name="answers[{{ $question->id }}]"
                                                    id="uploadFile_{{ $question->id }}" accept="image/*"
                                                    style="display: none;">
                                            </label>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="schedule_btn_pg6">
                            <button>Schedule</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/recorder.js') }}"></script>
    <script src="{{ asset('/js/patient/questionnaire.js') }}"></script>
@endsection
