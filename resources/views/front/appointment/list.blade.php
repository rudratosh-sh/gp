@extends('front.layouts.public')
@section('content')
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="header_col">
                <div class="super_logo">
                    <img class="site_logo" src="{{ asset('assets/logo.png') }}" alt="Logo">
                </div>
                <div class="user_details">
                    <div class="notifications">
                        <img src="{{ asset('assets/bell-notification.png') }}" alt="Notifications">
                    </div>
                    <div class="login_user">
                        <div class="circle">
                            <img src="{{ asset('assets/images/chat-profile.png') }}" alt="Profile">
                        </div>
                        <h4 class="user_name_txt">John Doe</h4>
                    </div>
                </div>
            </div>
        </header>
        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li id="dashboard-tab">Dashboard</li>
                <li class="active" id="booking-tab">Booking Appointment</li>
                <li id="referral-tab">Referral Letter</li>
                <li id="profile-tab">My Profile</li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx">
                <div class="booking_container">
                    <div class="spc_btn_pg8">
                        <h1 class="booking_title_pg8">Booking Appointment</h1>
                        <a href="page-4.html">+ Book Appointment</a>
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
                                            <div class="flx dis_center_pg8">
                                                <div class="box_message_img_pg8"></div>
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
@endsection
