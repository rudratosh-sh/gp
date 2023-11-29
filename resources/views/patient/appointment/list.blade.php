@extends('patient.layouts.public')
@section('content')
    <style>
        .a-tab-active {
            color: white;
            border: none;
            text-decoration: none;
        }

        .a-tab-inactive {
            color: #000;
            border: none;
            text-decoration: none;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')

        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li  class="active" id="dashboard-tab"><a  class="a-tab-active"href="{{route('appointment.schedule.list')}}">Dashboard</a></li>
                <li  id="booking-tab"><a class="a-tab-inactive" href="{{route('appointment.index.get')}}">Booking Appointment</a></li>
                <li id="referral-tab"><a  class="a-tab-inactive" href="#">Referral Letter</a></li>
                <li id="profile-tab"><a  class="a-tab-inactive" href="{{route('patient.profile.get')}}">My Profile</a></li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx">
                <div class="booking_container">
                    <div class="spc_btn_pg8">
                        <h1 class="booking_title_pg8">Booking Appointment</h1>
                        <a href="{{ route('appointment.index.get') }}">+ Book Appointment</a>
                    </div>
                    <div class="book_call_container_pg8">
                        @foreach ($appointments as $appointment)
                            <div class="doc_details_pg8">
                                <div class="card_pg8">
                                    <div class="left-section_pg8">
                                        <div class="small-image_pg8">
                                            <img src="{{ asset('assets/images/doctor-img.png') }}" alt="Doctor Profile">
                                        </div>
                                        <div class="doc_detail_pg8">
                                            <h2 class="title_pg8">{{ $appointment->doctor->name }}</h2>
                                            <p class="click-name_pg8">{{ $appointment->clinic->name }}</p>
                                            <div class="flx_space_btw">
                                                <p class="direction_2877_pg8">{{ $appointment->clinic->location }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="center_section_pg8">
                                        <div class="center_content_pg8">
                                            <span class="btn_bt_pg8">Booking Video Call Consultation</span>
                                            <div class="flx items-center column-gap-10 " >
                                                <div class="box_message_img_pg8" style="cursor: pointer; "></div>
                                                <p class="direction_pg8" style="cursor: pointer;" >2 Messages</p>
                                                <p class="direction_pg8">7km</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="right_section_pg8">
                                        <div class="full_wd_pg8">
                                            <div class="appointment_content_pg8">
                                                <div class="appointment_time_pg8">
                                                    <p class="appointment_date_pg8">Appointment Date:</p>
                                                    <p class="appointment_time_bold_pg8">
                                                        {{ date('d F Y', strtotime($appointment->appointment_date_time)) }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="meet_content_pg8">
                                                <div class="joining_meet_pg8">
                                                    <p class="time_meet_pg8">Join in:</p>
                                                    <p class="joining_time_pg8">
                                                        {{ date('H:i', strtotime($appointment->appointment_date_time)) }}
                                                    </p>
                                                </div>
                                                <div class="meet_icon_join_pg8">
                                                    <img src="{{ asset('assets/images/paper-plane.svg') }}" alt=""
                                                        class="meet-icon_pg8">
                                                    <p class="p_join_pg8">Join Meet</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        <div class="bottom-menu-wrapper">
            <div class="b-menu"><img src="{{ asset('assets/images/menu1.png') }}" alt="Menu 1"></div>
            <div class="b-menu active"><img src="{{ asset('assets/images/menu2.png') }}" alt="Menu 2"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu3.png') }}" alt="Menu 3"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu4.png') }}" alt="Menu 4"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu5.png') }}" alt="Menu 5"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/patient/list.js') }}"></script>
@endsection
