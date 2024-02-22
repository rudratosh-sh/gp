@extends('patient.layouts.public', ['page_title' => 'Referral Letter'])
@section('content')
    {{-- <style>
        .a-tab-active {
            color: black !important;
            border: none;
            text-decoration: none;
        }

        .a-tab-inactive {
            /* color: #fff !important; */
            border: none;
            text-decoration: none;
        }
    </style> --}}
    <style>
        .hide {
            display: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust the opacity as needed */
            backdrop-filter: blur(5px);
            /* Apply the blur effect */
            z-index: 1;
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            z-index: 2;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')
        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li id="dashboard-tab"><a style="all:unset"
                        class="a-tab-inactive"href="{{ route('appointment.schedule.list') }}">Dashboard</a></li>
                <li id="booking-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('appointment.index.get') }}">Booking
                        Appointment</a></li>
                <li class="active" id="referral-tab"><a style="all:unset" class="a-tab-active"
                        href="{{ route('referal.index.get') }}">Referral Letter</a></li>
                <li id="profile-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('patient.profile.get') }}">My Profile</a></li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx">
                <div class="booking_container">
                    <div class="spc_btn_pg11">
                        <h1 class="booking_title_pg11">Referral Letter</h1>
                        <a href="{{ route('appointment.index.get') }}">+ Book Appointment</a>
                    </div>
                    <div class="overlay hide"></div>
                    <div class="book_call_container">
                        @foreach ($appointments as $appointment)
                            @include('patient.modals.referral', [
                                'vitals' => $appointment->patientVitalValues,
                                'medicareDetail' => $appointment->medicareDetail,
                                'user' => $appointment->user,
                                'appointment' => $appointment,
                            ])
                            <div class="backdrop close"></div>
                            @if ($appointment->refLetter != null)
                                <div class="doc_details_pg11">
                                    <div class="card_pg6">
                                        <div class="left-section_pg6">
                                            <div class="left-section-wrapper">
                                                <div class="small-image_pg6"><img src="../assets/images/doctor-img.png"
                                                        alt=""></div>
                                                <div class="doc_detail_pg6">
                                                    <h2 class="title_pg6">{{ $appointment->doctor->name }}</h2>
                                                    <p class="click-name_pg6">{{ $appointment->clinic->name }}</p>
                                                    <div class="flx_space_btw">
                                                        <p class="direction_pg11">{{ $appointment->clinic->address }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="center_section_pg11">
                                            <div class="center_content_pg11">
                                                <div class="flx items-center column-gap-10" id="openModalButton">
                                                    <div class="box_message_img_pg8"></div>
                                                    <p class="direction_pg8">2 Messages</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right_section_pg11">
                                            <div class="full_wd_pg11">
                                                <div class="appointment_content_pg11">
                                                    <div class="appointment_time_pg11">
                                                        <span class="btn_bt_pg11 open-modal"
                                                            data-modal-target=".referralModal">View Referral Letter</span>
                                                    </div>
                                                </div>
                                                <div class="meet_content_pg11">
                                                    <p class="appointment_date_pg8">Appointment Date:</p>
                                                    <p class="appointment_time_bold_pg8">20 july 2023</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
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
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="{{ asset('/js/patient/list.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Function to toggle the overlay and modal visibility
            $('.open-modal').click(function() {
                var modalTarget = $(this).data('modal-target');
                $(modalTarget).toggleClass('hide');
                $('.overlay').toggleClass('hide');
            });
            $('.close-modal-btn').click(function() {
                var target = $(this).data('modal-target');
                $(target).toggleClass('hide');
                $('.overlay').toggleClass('hide');
            });
        });
    </script>
@endsection
