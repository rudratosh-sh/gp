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
                <form id="scheduleForm" method="POST" action="{{ route('appointment.questionnaire.store') }}" enctype="multipart/form-data">
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
                                <div class="asking_problem">
                                    <h1 class="light_txt_pg6">{{ $question->question_text }}</h1>
                                    <div class="speak_txt_content_pg6">
                                        @if ($question->input_type === 'text')
                                            <input type="text" name="answers[{{ $question->id }}]" class="user_txt_pg6" />
                                        @elseif ($question->input_type === 'file')
                                            <div class="upload_photo_pg6">
                                                <input type="file" name="answers[{{ $question->id }}]" accept="image/*" />
                                            </div>
                                        @endif
                                        <img class="image_box_pg6" alt="" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Schedule Btn -->
                        <div class="schedule_btn_pg6">
                            <button>Schedule</button>
                        </div>
            </div>
                </form>
        </div>
    </div>
    </div>
    </div>
    <script>
        // Get the tabs
        var dashboardTab = document.getElementById("dashboard-tab");
        var bookingTab = document.getElementById("booking-tab");
        var referralTab = document.getElementById("referral-tab");
        var profileTab = document.getElementById("profile-tab");

        // Function to handle the click event on booking tab
        function handleBookingClick() {
            // Remove active class from all tabs
            var tabs = document.getElementsByTagName("li");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }

            // Add active class to booking tab
            bookingTab.classList.add("active");

            // Navigate to the booking page
            window.location.href = "page4.html"; // Replace 'page4.html' with the path to your booking page
        }

        // Attach click event listener to booking tab
        bookingTab.addEventListener("click", handleBookingClick);

        // Function to handle the click event on referral tab
        function handleReferralClick() {
            // Remove active class from all tabs
            var tabs = document.getElementsByTagName("li");
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }

            // Add active class to referral tab
            referralTab.classList.add("active");

            // Navigate to the referral page
            window.location.href = "page11.html"; // Replace 'page11.html' with the path to your referral page
        }

        // Attach click event listener to referral tab
        referralTab.addEventListener("click", handleReferralClick);

        function navigateToPage(pageURL) {
            window.location.href = pageURL;
        }
    </script>
@endsection
