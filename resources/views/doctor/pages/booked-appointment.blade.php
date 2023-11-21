@extends('doctor.layouts.doctor-layout')

@section('content')
    <!-- MESSAGES MODAL Start-->
    @include('doctor.modals.messages')
    <!-- MESSAGES MODAL end-->

    <!-- Notification MODAL Start-->
    @include('doctor.modals.notification')
    <!-- Notification MODAL end-->

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
        {{-- <div style="width:100%;">
            <div id="test" style="display: flex; margin-top: 20px;">
                <div class="current-months"></div>
                <div id="test1" style="display: flex;">
                    <button class="prev soft-btns"
                        style="background: #F8F8F8 0% 0% no-repeat padding-box;
                border-radius: 10px;
                opacity: 1;"><i
                            class="fas fa-chevron-left"></i></button>
                    <div
                        style="height: 40px; padding: 7px 20px;font-weight: 400;color: #707070;opacity: 1;font-size: 16px;background: #F8F8F8 0% 0% no-repeat padding-box;border-radius: 10px;width: 92px;margin: 0 8px;">
                        Today</div>
                    <button class="next soft-btns"
                        style="background: #F8F8F8 0% 0% no-repeat padding-box;
                border-radius: 10px;
                opacity: 1;"><i
                            class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="content-right">
                <div class="status">
                    Today
                </div>
                <div class="content-status">Waiting Area…</div>
            </div>
            <div>
                <div style="display: flex;margin-top: 20px;">
                    <div class="card-left">
                        <div>10:00 AM</div>
                    </div>
                    <hr style="height: 700px;" />


                    <div class="card-right">
                        <div class="card-right-content">
                            <div style="display: flex;gap: 10px;align-items: center;">
                                <img src="../assets/images/video-camera-alt.svg" alt="video-camera"
                                    style="height: 24px;width: 24px;" />
                                <div>
                                    <div onclick="navigateToPage('/gp/patient-details.html')" class="card-right-name">Sean
                                        Rada
                                    </div>
                                    <div class="card-right-details">
                                        <div>Male</div>
                                        <div>45</div>
                                        <div>1234567890</div>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div class="card-right-video">
                                    Join in:
                                    <span class="right-video-time">12:45</span>
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
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Appointment List Start -->
        <!-- Appointment List Start -->
        <div style="width:100%;">
            @for ($hour = 10; $hour <= 22; $hour++)
                @php
                    $timeSlot = sprintf('%02d:00', $hour);
                    $foundAppointment = false;
                @endphp
                <div id="slot_{{ $timeSlot }}" style="display: flex; margin-top: 20px;">
                    <div class="card-left">
                        <div>{{ $timeSlot }}</div>
                    </div>
                    <hr style="height: 700px;" />
                    @if (isset($appointments))
                        @foreach ($appointments as $appointment)
                            @php
                                $appointmentTime = date('H:i', strtotime($appointment->appointment_date_time));
                            @endphp
                            @if ($timeSlot === $appointmentTime)
                                <!-- Render each appointment for this time slot -->
                                <div class="card-right">
                                    <div class="card-right-content">
                                        <div style="display: flex;gap: 10px;align-items: center;">
                                            <img src="../assets/images/video-camera-alt.svg" alt="video-camera"
                                                style="height: 24px;width: 24px;" />
                                            <div>
                                                <div onclick="navigateToPage('/gp/patient-details.html')"
                                                    class="card-right-name">
                                                    {{ $appointment->user->name }}
                                                    <!-- Assuming user's name exists in the appointment -->
                                                </div>
                                                <div class="card-right-details">
                                                    <div>{{ $appointment->user->gender }}</div>
                                                    <!-- Example: Display user's gender -->
                                                    <div>{{ $appointment->user->age }}</div>
                                                    <!-- Example: Display user's age -->
                                                    <div>{{ $appointment->user->phone }}</div>
                                                    <!-- Example: Display user's phone -->
                                                </div>
                                            </div>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div class="card-right-video">
                                                Join in: <span class="right-video-time">{{ $timeSlot }}</span>
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
                                </div>
                            @endif
                        @endforeach
                    @else
                        <!-- No appointments for this time slot -->
                        <div class="card-right">
                            <div class="card-right-content">
                                <div>No Appointments</div>
                            </div>
                        </div>
                    @endif
                </div>
            @endfor
        </div>
        <!-- Appointment list end -->

        <!-- Appointment list end -->

        <!-- Appointment list end -->
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let currentMonth = $(".current-month");
            let currentMonths = $(".current-months");
            let calendarDays = $(".calendar-days");
            let today = new Date();
            let date = new Date();
            let openCard = $(".open-card");
            let rightMessagesBtn = $('.right-messages');
            let headerUserProfile = $(".login_user");
            let openNotificationModal = $("#openNotificationModal");

            currentMonth.text(date.toLocaleDateString("en-IN", {
                month: 'long',
                year: 'numeric'
            }));
            today.setHours(0, 0, 0, 0);
            currentMonths.text(date.toLocaleDateString("en-IN", {
                day: "2-digit",
                month: 'long',
                year: 'numeric'
            }));
            today.setHours(0, 0, 0, 0);
            renderCalendar();

            function renderCalendar() {
                const prevLastDay = new Date(date.getFullYear(), date.getMonth(), 0).getDate();
                const totalMonthDay = new Date(date.getFullYear(), date.getMonth() + 1, 0).getDate();
                const startWeekDay = new Date(date.getFullYear(), date.getMonth(), 1).getDay();
                calendarDays.html("");
                let totalCalendarDay = 6 * 7;
                for (let i = 0; i < totalCalendarDay; i++) {
                    let day = i - startWeekDay;
                    if (i <= startWeekDay) {
                        // adding previous month days
                        calendarDays.append(`<div class='padding-day'>${prevLastDay - i}</div>`);
                    } else if (i <= startWeekDay + totalMonthDay) {
                        // adding this month days
                        date.setDate(day);
                        date.setHours(0, 0, 0, 0);
                        let dayClass = date.getTime() === today.getTime() ? 'current-day' : 'month-day';
                        calendarDays.append(`<div class='${dayClass}'>${day}</div>`);
                    } else {
                        // adding next month days
                        calendarDays.append(`<div class='padding-day'>${day - totalMonthDay}</div>`);
                    }
                }
            }

            $(".soft-btn").on("click", function() {
                date = new Date(currentMonth.text());
                let dates = new Date(currentMonths.text());
                date.setMonth(date.getMonth() + ($(this).hasClass("prev") ? -1 : 1));
                currentMonth.text(date.toLocaleDateString("en-US", {
                    month: 'long',
                    year: 'numeric'
                }));
                currentMonths.text(date.toLocaleDateString("en-US", {
                    day: "2-digit",
                    month: 'long',
                    year: 'numeric'
                }));
                renderCalendar();
            });

            $(".btn").on("click", function() {
                let btnClass = $(this).attr('class');
                date = new Date(currentMonth.text());
                if (btnClass.includes("today"))
                    date = new Date();
                else if (btnClass.includes("prev-year"))
                    date = new Date(date.getFullYear() - 1, 0, 1);
                else
                    date = new Date(date.getFullYear() + 1, 0, 1);
                currentMonth.text(date.toLocaleDateString("en-US", {
                    month: 'long',
                    year: 'numeric'
                }));
                renderCalendar();
            });

            const activityCards = $(".activity-card");
            openCard.each(function(index) {
                $(this).on('click', function(event) {
                    event.stopPropagation();

                    activityCards.each(function(i) {
                        if (i !== index) {
                            $(this).hide();
                        }
                    });

                    const activityCard = activityCards.eq(index);
                    if (activityCard.css('display') === 'none' || activityCard.css('display') ===
                        '') {
                        activityCard.css('display', 'flex');
                    } else {
                        activityCard.css('display', 'none');
                    }
                });
            });

            $(".activity-btn").on("click", function() {
                $(".backdrop").addClass("backdrop-open");
                $(".model-content-activity").removeClass("hide");
            });

            $("div.close").on("click", function() {
                $(".backdrop").removeClass("backdrop-open");
                $(".model-content-activity").addClass("hide");
            });

            function openModalContainer(event) {
                $(".modal-container").css('display', 'block');
            }

            rightMessagesBtn.each(function() {
                $(this).on('click', openModalContainer);
            });

            function closeModalContainer(event) {
                let modalContainer = $(".modal-container");

                if (modalContainer.css('display') === 'block' && $(event.target).hasClass('modal-container')) {
                    modalContainer.css('display', 'none');
                }
            }

            $(document).on('click', closeModalContainer);

            function handleHeaderUserProfile() {
                let userPopup = $('.user_profile_popup');
                let userProfileImage = $('.circles').find('img');
                let userName = $('.user_name_txts');

                if (userPopup.css('display') === 'flex') {
                    userPopup.css('display', 'none');
                } else {
                    userPopup.css('display', 'flex');
                }

                $(document).on('click', function(event) {
                    if (!$(event.target).is(userProfileImage) && !$(event.target).is(userName) && !$(event
                            .target).is(userPopup)) {
                        userPopup.css('display', 'none');
                    }
                });
            }

            headerUserProfile.on('click', handleHeaderUserProfile);

            function closeNotificationModalContainer(event) {
                let modalContainer = $(".modal-container-notification");

                if (modalContainer.css('display') === 'block' && $(event.target).hasClass(
                        'modal-container-notification')) {
                    modalContainer.css('display', 'none');
                }
            }

            function openNotificationModalContainer(event) {
                $(".modal-container-notification").css('display', 'block');
            }

            openNotificationModal.on('click', openNotificationModalContainer);
            $(document).on('click', closeNotificationModalContainer);

            function navigateToPage(pageURL) {
                window.location.href = pageURL;
            }
        });
    </script>
@endsection
