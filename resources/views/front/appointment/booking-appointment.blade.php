@extends('front.layouts.public')
<style>
    /* CSS styles for the updated search box */
    .search-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .input_container {
        flex: 1;
        margin-right: 20px;
        margin-top: 17px;
    }

    .search-box {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .search-box2 {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
    }

    .search-button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Style for spacing between location and doctor selection */
    .pd-15 {
        margin-top: 15px;
    }
</style>
@section('content')
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
                            <div class="tab active">
                                <div class="dis_flx_center">
                                    <div class="tab_circle">
                                        <span class="step-count">1</span>
                                    </div>
                                    <a class="tab_title">Select Clinic</a>
                                </div>
                            </div>
                            <div class="tab">
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

                    <!-- SEARCH BOX -->
                    <div class="search-container">
                        <div class="input_container">
                            <h2 class="sub-title">Location</h2>
                            <select class="search-box" id="locationSelect">
                                <option value="">Select Location</option>
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}">{{ $location->location }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pd-15">
                            <h2 class="sub-title">Select Doctor</h2>
                            <select class="search-box2" id="doctorSelect">
                                <option value="">Select Doctor</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="search-button" id="searchDoctorsAndClinics">Search</button>
                    </div>


                    <!-- Top GP Section -->
                    <div id="topGpSection" class="top_gp">
                        <div class="gp_call">
                            <h1 class="gp_title">Top GP</h1>
                            <div class="parent_card_container">
                                @foreach ($doctors as $doctor)
                                    <div class="card">
                                        <div class="left-section">
                                            <div class="small-image"></div>
                                            <div class="doc_details">
                                                <h2 class="title">{{ $doctor->name }}</h2>
                                                <p class="click-name">{{ $doctor->clinic->name }}</p>
                                                <div class="flx_space_btw">
                                                    <p class="direction">{{ $doctor->clinic->location }}</p>
                                                    <p class="direction">{{ 1.4 }}km</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-section">
                                            <button class="button1">Get Referral</button>
                                            <a class="button2" href="booking/{{ $doctor->id }}">Book a Visit</a>
                                            <button class="button3">Book Video Call</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Clinics Section -->
                    <div id="clinicSection" class="clinic_container">
                        <h1 class="click_title">Clinic</h1>
                        <div class="clinic_content">
                            @foreach ($locations as $location)
                                <div class="card-clinic">
                                    <div class="first-section"></div>
                                    <div class="second-section">
                                        <h4 class="title">{{ $location->name }}</h4>
                                        <img src="image.jpg" alt="Navigate" class="navigate-image" />
                                    </div>
                                </div>
                            @endforeach
                            <!-- Dynamic content will be added here -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.search-button').click(function() {
                var locationId = $('#locationSelect').val();
                var specialistId = $('#doctorSelect').val();

                $.ajax({
                    type: 'POST',
                    url: "{{ route('search.clinics.doctors') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        location: locationId,
                        specialist: specialistId
                    },
                    success: function(response) {
                        // Handle the response and update the "Top GP" and "Clinic" sections
                        updateTopGpSection(response.doctors);
                        updateClinicSection(response.clinics);
                    },
                    error: function(error) {
                        console.error('Ajax request error:', error);
                    }
                });
            });

            function updateTopGpSection(doctors) {
                // Assuming the "Top GP" section has an element with the ID "topGpSection"
                var topGpSection = $('#topGpSection');

                // Clear the existing content
                topGpSection.empty();

                // Loop through the doctors and create cards
                if (doctors.length > 0) {
                    var cardHtml = `<div class="gp_call">
                <h1 class="gp_title">Top GP</h1><div class="parent_card_container">`

                    doctors.forEach(function(doctor) {
                        var clinicName = doctor.clinic ? doctor.clinic.name : 'N/A'; // Check if clinic is defined
            var clinicLocation = doctor.clinic ? doctor.clinic.location : 'N/A';

            cardHtml += `
                <div class="card">
                    <div class="left-section">
                        <div class="small-image"></div>
                        <div class="doc_details">
                            <h2 class="title">${doctor.name}</h2>
                            <p class="click-name">${clinicName}</p>
                            <div class="flx_space_btw">
                                <p class="direction">${clinicLocation}</p>
                                <p class="direction">${1.4}km</p>
                            </div>
                        </div>
                    </div>
                    <div class="right-section">
                        <button class="button1">Get Referral</button>
                        <a class="button2" href="booking/${doctor.id}">Book a Visit</a>
                        <button class="button3">Book Video Call</button>
                    </div>
                </div>
            `;
                        // Append the card HTML to the "Top GP" section
                        topGpSection.append(cardHtml);
                    });
                } else {
                    // No doctors available
                    topGpSection.html('<p>No doctors available</p>');
                }
            }

            function updateClinicSection(clinics) {
                // Assuming the "Clinic" section has an element with the ID "clinicSection"
                var clinicSection = $('#clinicSection');

                // Clear the existing content
                clinicSection.empty();

                // Loop through the clinics and create cards
                if (clinics.length > 0) {
                    var cardHtml = `<h1 class="click_title">Clinic</h1> <div class="clinic_content">`
                    clinics.forEach(function(clinic) {
                        cardHtml += `
                <div class="card-clinic">
                    <div class="first-section"></div>
                    <div class="second-section">
                        <h4 class="title">${clinic.name}</h4>
                        <img src="image.jpg" alt="Navigate" class="navigate-image" />
                    </div>
                </div>
                </div>
            `;

                        // Append the card HTML to the "Clinic" section
                        clinicSection.append(cardHtml);
                    });
                } else {
                    // No clinics available
                    clinicSection.html('<p>No clinics available</p>');
                }
            }
        });

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
