@extends('front.layouts.public')

@section('content')
    <style>
        .calendar_pg7 {
            width: 354px;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        <header>
            <div class="header_col">
                <div class="super_logo">
                    <img class="site_logo" src="{{ asset('assets/MaskGP1.png') }}" />
                </div>
                <div class="user_details">
                    <div class="notifications">
                        <img src="{{ asset('assets/bell.svg') }}" />
                    </div>
                    <div class="login_user">
                        <div class="circle"></div>

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
                    <h1 class="booking_title">Booking Appointment</h1>
                    <div class="clinic_counter">
                        <div class="tabs">
                            <div class="tab">
                                <div class="dis_flx_center">
                                    <div class="tab_circle">
                                        <span class="step-count">1</span>
                                    </div>
                                    <a href="{{ url('page4.html') }}" class="tab_title">Select Clinic</a>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="dis_flx_center">
                                    <div class="tab_circle">
                                        <span class="step-count">2</span>
                                    </div>
                                    <a class="tab_title" href="{{ url('page6.html') }}"> Questionnaire </a>
                                </div>
                            </div>
                            <div class="tab active">
                                <div class="dis_flx_center">
                                    <div class="tab_circle">
                                        <span class="step-count">3</span>
                                    </div>
                                    <a class="tab_title" href="{{ url('page7.html') }}">Schedule</a>
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
                                        <h2 class="title_pg6">Dr. Giana Gonzas</h2>
                                        <p class="click-name_pg6">XYZ & More Clinic</p>
                                        <div class="flx_space_btw">
                                            <p class="direction_pg6">South Wales 2877 Australia</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="center_section_pg6">
                                    <div class="center_content_pg6">
                                        <h2 class="title_pg6">Dr. Giana Gonzas</h2>
                                        <div class="flx_space_btw dis_center_pg6">
                                            <p class="direction_pg6">South Wales 2877 Australia</p>
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

                    <div class="question_container_pg7">
                        <div class="calendar_pg7">
                            <div id="calendar"></div>

                            <div class="radio_content_pg7">
                                <div class="radio-container_pg7">
                                    <input type="radio" checked="true" disabled id="booked"  class="radio-input_pg7"
                                        value="booked" />
                                    <label for="booked" class="radio-custom_pg7"></label>
                                    <label for="booked" class="radio-label_pg7">Booked</label>
                                </div>

                                <div class="radio-container_pg7">
                                    <input type="radio" checked disabled id="available"  class="radio-input_pg7"
                                        value="available" />
                                    <label for="available" class="radio-custom_pg7"></label>
                                    <label for="available" class="radio-label_pg7">Available</label>
                                </div>
                            </div>
                        </div>

                        <div class="meet_content_pg7">
                            <table class="schedule_pg7">
                                <thead>
                                    <tr>
                                        <th class="border_none_pg7 txt_end_pg7">
                                            <span class="backword_btn_pg7">
                                            </span>
                                        </th>
                                        <th class="border_none_pg7">
                                            <!-- <div> -->
                                            <p>01</p>
                                            <p class="light_pg7">SUN</p>
                                            <!-- </div> -->
                                        </th>
                                        <th class="border_none_pg7">
                                            <p>02</p>
                                            <p class="light_pg7">NON</p>
                                        </th>
                                        <th class="border_none_pg7">
                                            <p>03</p>
                                            <p class="light_pg7">TUE</p>
                                        </th>
                                        <th class="border_none_pg7">
                                            <p>04</p>
                                            <p class="light_pg7">WED</p>
                                        </th>
                                        <th class="border_none_pg7">
                                            <p>05</p>
                                            <p class="light_pg7">THU</p>
                                        </th>
                                        <th class="border_none_pg7">
                                            <p>06</p>
                                            <p class="light_pg7">FRI</p>
                                        </th>
                                        <th class="border_none_pg7 pos_rel_pg7">
                                            <!-- <div> -->
                                            <p>07</p>
                                            <p class="light_pg7">SAT</p>
                                            <!-- </div> -->
                                            <span class="pos_abs_pg7">></span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="meet_timing border_none_pg7 border_top_pg7">
                                            09 AM
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>

                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">10 AM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">11 AM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">12 AM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">01 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">02 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">03 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">04 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">05 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>

                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <!-- <span class="meet-icon_pg7"></span> -->
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>
                                    <tr>
                                        <td class="meet_timing border_none_pg7">06 PM</td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-scheduled_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/Meet_icon.png') }}" alt=""
                                                    class="meet-icon_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                        <td class="meet-done_pg7">
                                            <div class="meet_icon_content_pg7">
                                                <img src="{{ asset('assets/house_building.png') }}") alt=""
                                                    class="meet-icon_building_pg7" />
                                            </div>
                                        </td>
                                        <td class="meet-not-scheduled_pg7"></td>
                                    </tr>

                                    <!-- Repeat the above row for other time slots -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="schedule_btn_pg7">
                        <a href="{{ url('page-8.html') }}">Schedule</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
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
    <!-- resources/views/layouts/app.blade.php or your Blade view -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth'
            });
            calendar.render();

            // Initialize the table with the current date
            var currentDate = new Date(); // You can replace this with your initial date
            updateTable(calendar, currentDate);

            // Example: Use FullCalendar's dateClick event to update the table when a date is clicked
            calendar.on('dateClick', function(info) {
                console.log('herere',info.date)
                updateTable(calendar, info.date);
            });
        });
    </script>

    <!-- JavaScript to update the table based on the selected date -->
    <script>
        // This function will update the table based on the selected date
        function updateTable(calendar, selectedDate) {
            // Check if selectedDate is a valid date
            if (!(selectedDate instanceof Date) || isNaN(selectedDate.getTime())) {
                console.error('Invalid date:', selectedDate);
                return;
            }

            // Example: Get the day of the selected date (1 for Sunday, 2 for Monday, etc.)
            var dayOfWeek = selectedDate.getDay();

            // Example: Get the day of the month of the selected date (1 to 31)
            var dayOfMonth = selectedDate.getDate();

            // Example: Update the table with the selected date information
            // Replace this logic with your own to populate the table cells as needed
            $('table.schedule_pg7 thead th').each(function(index) {
                if (index > 0) {
                    // Calculate the date for each day column (add dayOfMonth - dayOfWeek to index)
                    var updatedDate = new Date(selectedDate);
                    console.log('selectedDate',selectedDate)
                    console.log('updatedDate',updatedDate)
                    console.log('dayOfMonth',dayOfMonth)
                    console.log('dayOfWeek',dayOfWeek)
                    console.log('index',index)
                    updatedDate.setDate(dayOfMonth + index);
                    console.log('next updatedDate',updatedDate)

                    // Update the table cell text with the formatted date
                    $(this).text(updatedDate.toLocaleDateString('en-US', {
                        day: 'numeric',
                        weekday: 'short'
                    }));
                }
            });

            // You can also update the slot data based on the selected date here
            // Replace this logic to populate slot data as needed
            // Example: $('.meet-scheduled_pg7').text('Meeting Scheduled');
            // ...

            // This is just an example; adjust the logic to your specific requirements
        }
    </script>
@endsection
