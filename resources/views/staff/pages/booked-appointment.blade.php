@extends('staff.layouts.staff-layout')

@section('content')
    <style>
        .right-hr {
            border-right: 1px solid black;
            width: 45px;
        }
    </style>

    <div class="content">
        <!-- Appointment Calender Start-->
        <div style="margin-top: 20px;">
            <div class="softcard">
                <div class="calendar-bar">
                    <div style="display: flex;align-items: center;">
                        <div class="current-month"></div>
                        <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 320 512">
                            <!-- Font Awesome SVG Path -->
                            <path
                                d="M137.4 374.6c12.5 12.5 32.8 12.5 45.3 0l128-128c9.2-9.2 11.9-22.9 6.9-34.9s-16.6-19.8-29.6-19.8L32 192c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9l128 128z" />
                        </svg>
                    </div>
                    <button class="prev soft-btn"><i class="fas fa-chevron-left"></i></button>
                    <button class="next soft-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="calendar">
                    <div class="weekdays-name">
                        <div class="days-name">Sa</div>
                        <div class="days-name">Su</div>
                        <div class="days-name">Mo</div>
                        <div class="days-name">Tu</div>
                        <div class="days-name">We</div>
                        <div class="days-name">Th</div>
                        <div class="days-name">Fr</div>
                    </div>
                    <hr style="margin: 0 30px 10px;" />
                    <div class="calendar-days"></div>
                </div>
            </div>
            <div class="bottom-menu-wrapper">
                <div class="b-menu"><img src="{{ asset('assets/images/menu1.png') }}" alt="menu"></div>
                <div class="b-menu active"><img src="{{ asset('assets/images/menu2.png') }}" alt="menu"></div>
                <div class="b-menu"><img src="{{ asset('assets/images/menu3.png') }}" alt="menu"></div>
                <div class="b-menu"><img src="{{ asset('assets/images/menu4.png') }}" alt="menu"></div>
                <div class="b-menu"><img src="{{ asset('assets/images/menu5.png') }}" alt="menu"></div>
            </div>
        </div>
        <!-- Appointment Calender End-->

        <!-- Appointment List Start -->
        <div style="width:100%;">
            <div id="test" style="display: flex; margin-top: 20px;">
                <div class="current-months">{{ now()->format('d F Y') }}</div>
                <div id="test1" style="display: flex;">
                    <button class="prev soft-btns" id="prevBtn"
                        style="background: #F8F8F8 0% 0% no-repeat padding-box;
                        border-radius: 10px;
                        opacity: 1;cursor:pointer;"><i
                            class="fas fa-chevron-left"></i></button>
                    <div class="today-btn"
                        style="height: 40px; padding: 7px 20px;font-weight: 400;color: #707070;opacity: 1;font-size: 16px;background: #F8F8F8 0% 0% no-repeat padding-box;border-radius: 10px;width: 92px;margin: 0 8px;cursor:pointer;">
                        Today</div>
                    <button class="next soft-btns" id="nextBtn"
                        style="background: #F8F8F8 0% 0% no-repeat padding-box;
                        border-radius: 10px;
                        opacity: 1;cursor:pointer;"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="content-right">
                <div class="status">
                    Today
                </div>
                <div class="content-status">Waiting Area…</div>
            </div>
            <div style="display: flex;margin-top: 20px;">
                <div class="card-right">
                    @foreach ($appointments as $key => $appointment)
                        {{-- @if ($timeSlot === $appointmentTime[$key]) --}}
                        <!-- Render each appointment for this time slot -->
                        <div class="card-right-content">
                            <div style="display: flex;gap: 10px;align-items: center;">
                                @if ($appointment->booking_type == 'video')
                                    <img src="../assets/images/video-camera-alt.svg" alt="video-camera"
                                        style="height: 24px;width: 24px;" />
                                @else
                                    <img src="../assets/images/hospital-user(1).svg" alt="video-camera"
                                        style="height: 24px;width: 24px;">
                                @endif
                                <div>
                                    <div onclick="navigateToPage('/gp/patient-details.html')" class="card-right-name">
                                        {{ $appointment->user->name }}
                                        <!-- Assuming user's name exists in the appointment -->
                                    </div>
                                    <div class="card-right-details">
                                        <div>{{ $appointment->medicareDetail->gender }}</div>
                                        <!-- Example: Display user's gender -->
                                        <div>
                                            {{ \Carbon\Carbon::parse($appointment->medicareDetail->birthdate)->age . ' Years' }}
                                        </div>
                                        <!-- Example: Display user's age -->
                                        <div>{{ $appointment->user->country_code . '-' . $appointment->user->mobile }}</div>
                                        <!-- Example: Display user's phone -->
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="card-right-video">
                                    Join in: <span
                                        class="right-video-time">{{ date('H:i', strtotime($appointment->appointment_date_time)) }}</span>
                                </div>
                                <button class="right-video-camera">
                                    <img src="../assets/images/video-camera-alt.svg" alt="video-camera"
                                        style="width: 24px;height: 16px;" />
                                    <div class="right-video-start">Join Now</div>
                                </button>
                                <button class="right-messages">
                                    <img src="../assets/images/messages.svg" alt="message"
                                        style="width: 28px;height: 28px;margin: 0 20px;">
                                </button>
                                <a class="right-vitals"
                                    href="{{ route('staff.patient.vitals', ['userId' => encrypt($appointment->user->id)]) }}">
                                    <img src="../assets/vitals-logo.svg" alt="video-camera"
                                        style="width: 24px; height: 16px;">
                                    <div class="right-video-start">Vitals</div>
                                </a>
                                <button class="open-card"
                                    style="position: relative;border-style: none;margin-right: 20px;margin-left:18px;">
                                    <i class='fa fa-ellipsis-v'></i>
                                    <div class="activity-card"
                                        style="z-index:2;position: absolute;background: #FFF;width: 138px;height: 120px;box-shadow: 0px 3px 6px #00000029;border-radius: 7px;right:0;margin-right:1rem;margin-top:-1.5rem;display:none;flex-direction: column;align-items: flex-start;row-gap: 1.5rem;padding: 1rem;">
                                        <span>Notify</span>
                                        <span class="activity-btn">Activity</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                        {{-- @endif --}}
                    @endforeach
                </div>
            </div>

        </div>
        <!-- Appointment list end -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('/js/staff/booked-appointment.js') }}"></script>
@endsection
