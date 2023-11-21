@extends('patient.layouts.public')

@section('content')
    <style>
        .calendar_pg7 {
            width: 354px;
        }

        /* Add this CSS to your stylesheet */
        .selected {
            background-color: #d2cfff;
            /* Change this to your desired background color */
            color: #fff;
            /* Change this to your desired text color */
            font-weight: bold;
            /* Change this to your desired font-weight */
            /* You can add more styles as needed to customize the appearance */
            border: 1px solid #d2cfff;
            cursor: pointer;
            /* Optional border for selected cells */
        }

        .booked {
            background-color: #d2cfff;
            /* Change this to your desired background color */
            color: #fff;
            /* Change this to your desired text color */
            font-weight: bold;
            /* Change this to your desired font-weight */
            /* You can add more styles as needed to customize the appearance */
            border: 1px solid #d2cfff;
            cursor: pointer;
            /* Optional border for selected cells */
        }

        .schedule_pg7 th,
        .schedule_pg7 td {
            cursor: pointer;
        }

        .schedule_pg7 td .appointment-container {
            display: flex;
            align-items: center;
        }

        .schedule_pg7 td .meet-icon_building_pg7 {
            margin-right: 10px;
        }

        .schedule_pg7 td .appointment-details span {
            margin-right: 10px;
        }

        .fc .fc-daygrid-day-frame {
            cursor: pointer;
        }

        .schedule_btn {
            padding: 20px 30px;
            border: none;
            border-radius: 12px;
            background: #59519E;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')

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
                    <form id="appointmentForm" action="{{ route('appointment.schedule.store') }}" method="POST">
                        @csrf <!-- Add CSRF token for Laravel -->

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
                                        <input type="radio" checked="true" disabled id="booked" class="radio-input_pg7"
                                            value="booked" />
                                        <label for="booked" class="radio-custom_pg7"
                                            style="background-color:#d2d1e2;border:#d2d1e2"></label>
                                        <label for="booked" class="radio-label_pg7">Booked</label>
                                    </div>

                                    <div class="radio-container_pg7">
                                        <input type="radio" checked disabled id="available" class="radio-input_pg7"
                                            value="available" />
                                        <label for="available" class="radio-custom_pg7"></label>
                                        <label for="available" class="radio-label_pg7">Available</label>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="selectedTime" name="selectedTime" value="">
                            <input type="hidden" id="selectedDate" name="selectedDate" value="">
                            <input type="hidden" id="selectedDetails" name="selectedDetails" value="">


                            <div id="calendar"></div>

                            <div class="meet_content_pg7">
                                <table class="schedule_pg7">
                                    <thead>
                                        <tr>
                                            <th class="border_none_pg7 txt_end_pg7">
                                            </th>
                                            <th class="border_none_pg7">
                                                <span class="backword_btn_pg7">
                                                </span>
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
                                            <td class="meet_timing border_none_pg7 border_top_pg7" data-time="09:00 AM">
                                                09 AM
                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM"></td>

                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="09:00 AM">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="10:00 AM">10 AM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM">
                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM">

                                            </td>
                                            <td class="meet-not-scheduled_pg7" data-time="10:00 AM">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="11:00 AM">11 AM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="11:00 AM"></td>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="12:00 AM">12 AM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="12:00 AM"></td>

                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="01:00 PM">01 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="01:00 PM"></td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="02:00 PM">02 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="02:00 PM"></td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="03:00 PM">03 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="03:00 PM"></td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="04:00 PM">04 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="04:00 PM"></td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="05:00 PM">05 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="05:00 PM"></td>
                                        </tr>
                                        <tr>
                                            <td class="meet_timing border_none_pg7" data-time="06:00 PM">06 PM</td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                            <td class="meet-not-scheduled_pg7" data-time="06:00 PM"></td>
                                        </tr>

                                        <!-- Repeat the above row for other time slots -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="schedule_btn_pg7">
                            <button class="schedule_btn" type="submit">Schedule</button>
                        </div>
                    </form>

                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                console.log('herere', info.date)
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
                    index = index - 1;
                    // Calculate the date for each day column (add dayOfMonth - dayOfWeek to index)
                    var updatedDate = new Date(selectedDate);
                    updatedDate.setDate(dayOfMonth + index);
                    console.log('this', this)

                    // Create a <span> element and add the class
                    var spanElement = document.createElement('span');
                    spanElement.textContent = updatedDate.toLocaleDateString('en-US', {
                        day: 'numeric',
                        weekday: 'short'
                    });
                    var formattedDate = ("0" + updatedDate.getDate()).slice(-2) + "-" +
                        ("0" + (updatedDate.getMonth() + 1)).slice(-2) + "-" +
                        updatedDate.getFullYear();

                    $(this).attr('date', formattedDate);
                    spanElement.classList.add('backword_btn_pg7'); // Add the class

                    // Clear the existing content and append the <span> element
                    $(this).empty().append(spanElement);
                }
            });

            $('table.schedule_pg7 tbody tr').each(function(rowIndex) {
                // Calculate the date for the first cell (add dayOfMonth to selectedDate)
                var updatedDate = new Date(selectedDate);
                // Loop through each <td> element in the row
                $(this).find('td.meet-not-scheduled_pg7').each(function(index) {
                    // Calculate the date for each <td> (increment days)
                    var dateForCell = new Date(updatedDate);
                    dateForCell.setDate(updatedDate.getDate() + index);

                    // Format the date as 'yyyy-MM-dd'
                    var formattedDate = dateForCell.getFullYear() + '-' +
                        ("0" + (dateForCell.getMonth() + 1)).slice(-2) + '-' +
                        ("0" + dateForCell.getDate()).slice(-2);

                    // Set the data-date attribute for the <td> element
                    $(this).attr('data-date', formattedDate);
                });
            });

            // Example: Use FullCalendar's dateClick event to update the table when a date is clicked
            calendar.on('dateClick', function(info) {
                console.log("info", info)
                // Fetch appointments for the clicked date
                fetchAppointments(info.date);
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get all the table rows
            var rows = document.querySelectorAll(".schedule_pg7 tbody tr");

            // Function to remove the "selected" class from all TDs
            function clearSelected() {
                var selectedTDs = document.querySelectorAll(".selected");
                selectedTDs.forEach(function(td) {
                    td.classList.remove("selected");
                });
            }

            // Function to update selectedTime and selectedDate inputs
            function updateSelectedInputs(td) {
                var time = td.getAttribute("data-time");
                var date = td.getAttribute("data-date");

                // Check if both time and date are present
                if (time && date) {
                    document.getElementById("selectedTime").value = time;
                    document.getElementById("selectedDate").value = date;
                }
            }

            // Add click event listeners to each TD
            rows.forEach(function(row) {
                var tds = row.querySelectorAll("td");
                tds.forEach(function(td) {
                    td.addEventListener("click", function() {
                        // Check if the TD has both data-time and data-date attributes
                        if (td.getAttribute("data-time") && td.getAttribute("data-date")) {
                            // Clear previously selected TDs
                            clearSelected();

                            // Add the "selected" class to the clicked TD
                            td.classList.add("selected");

                            // Update selectedTime and selectedDate inputs
                            updateSelectedInputs(td);
                        }
                    });
                });
            });
        });

        function fetchAppointments(date) {
            console.log("date", date)
            var selectedDate = date;
            var options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            };
            var formattedDate = selectedDate.toLocaleDateString('en-US', options).replace(/\//g, '-');
            // Make an AJAX GET request to fetch appointments by date
            $.ajax({
                url: '/api/appointments/' + formattedDate,
                type: 'GET',
                success: function(data) {
                    // Populate the table with appointment data
                    populateTable(data.data);
                },
                error: function() {
                    console.error('Failed to fetch appointments.');
                }
            });
        }

        function populateTable(appointments) {
            // Clear the existing table data
            $('table.schedule_pg7 tbody td.meet-not-scheduled_pg7').empty();
            $('table.schedule_pg7 tbody td.meet-not-scheduled_pg7').removeClass('booked');

            document.getElementById("selectedTime").value = '';
            document.getElementById("selectedDate").value = '';

            // Loop through the fetched appointments and populate the table
            appointments.forEach(function(appointment) {
                console.log(appointment, 'appointment')
                var appointmentDate = new Date(appointment.date);
                var appointmentTime = appointmentDate.toLocaleTimeString('en-US', {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true,
                }).replace(/(\d{2})([APap][Mm])/, '$1 $2');

                var formattedDate = appointmentDate.getFullYear() + '-' +
                    ("0" + (appointmentDate.getMonth() + 1)).slice(-2) + '-' +
                    ("0" + appointmentDate.getDate()).slice(-2);

                var element = $('td[data-time="' + appointmentTime + '"][data-date="' + formattedDate + '"]');
                element.addClass('booked');
                var container = $('<div>').addClass('appointment-container'); // Create a container div

                var appointmentIcon = $('<img>')
                    .attr('src', '{{ asset('assets/house_building.png') }}')
                    .attr('alt', '')
                    .addClass('meet-icon_building_pg7');
                container.append(appointmentIcon); // Append the image to the container
                var details = $('<div>').addClass('appointment-details'); // Create a div for appointment details
                // Add the appointment details to the details div
                details.append('<span>Doctor: ' + appointment.doctor + '</span>');
                details.append('<span>Clinic: ' + appointment.clinic + '</span>');
                if (appointment.details) {
                    details.append('<span>Details: ' + appointment.details + '</span>');
                }

                container.append(details); // Append the details div to the container
                element.append(container); // Append the container to the td element
            });
        }
    </script>
@endsection
