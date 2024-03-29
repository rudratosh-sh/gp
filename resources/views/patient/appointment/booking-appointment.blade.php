@extends('patient.layouts.public',['page_title'=>'Book An Appointment'])
@section('content')
<style>
    /* .a-tab-active{
    color: white;
    border: none;
    text-decoration: none;
    }

    .a-tab-inactive{
    color: #000;
    border: none;
    text-decoration: none;
    } */

</style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')

        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar">
                <li id="dashboard-tab"><a  style="all:unset" class="a-tab-inactive"href="{{route('appointment.schedule.list')}}">Dashboard</a></li>
                <li class="active" id="booking-tab"><a  style="all:unset" class="a-tab-active" href="{{route('appointment.index.get')}}">Booking Appointment</a></li>
                <li id="referral-tab"><a  style="all:unset" class="a-tab-inbactive" href="{{route('referal.index.get')}}">Referral Letter</a></li>
                <li id="profile-tab"><a  style="all:unset" class="a-tab-inactive" href="{{ route('patient.profile.get') }}">My Profile</a></li>
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
                                    <a class="tab_title" href="#"> Questionnaire </a>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="dis_flx_center">
                                    <div class="tab_circle">
                                        <span class="step-count">3</span>
                                    </div>
                                    <a class="tab_title" href="#">Schedule</a>
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
                                    <option value="{{ $doctor->user_id }}">{{ $doctor->user->name }}</option>
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
                                                <h2 class="title">{{ $doctor->user->name }}</h2>
                                                <p class="click-name">{{ $doctor->clinic->name }}</p>
                                                <div class="flx_space_btw">
                                                    <p class="direction">{{ $doctor->clinic->location }}</p>
                                                    <p class="direction">{{ 1.4 }}km</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right-section">
                                            <button class="button1">Get Referral</button>
                                            <a class="button2" href="booking/{{ $doctor->user_id }}/visit">Book a Visit</a>
                                            <a class="button3" href="booking/{{ $doctor->user_id }}/video">Book Video Call</a>
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
                                    <div class="first-section">
                                        <img src="{{ $location->banner_image_url }}" class="banner-image" />
                                    </div>
                                    <div class="second-section">
                                        <h4 class="title">{{ $location->name }}</h4>
                                        <img src="{{ $location->profile_icon_url }}" alt="Navigate"
                                            class="navigate-image" />
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
                        var clinicName = doctor.clinic ? doctor.clinic.name :
                            'N/A'; // Check if clinic is defined
                        var clinicLocation = doctor.clinic ? doctor.clinic.location : 'N/A';

                        cardHtml += `
                <div class="card">
                    <div class="left-section">
                        <div class="small-image"></div>
                        <div class="doc_details">
                            <h2 class="title">${doctor.user.name}</h2>
                            <p class="click-name">${clinicName}</p>
                            <div class="flx_space_btw">
                                <p class="direction">${clinicLocation}</p>
                                <p class="direction">${1.4}km</p>
                            </div>
                        </div>
                    </div>
                    <div class="right-section">
                        <button class="button1">Get Referral</button>
                        <a class="button2" href="booking/${doctor.user_id}/visit">Book a Visit</a>
                        <a class="button3" href="booking/${doctor.user_id}/video">video</a>
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
                    var cardHtml = `<h1 class="click_title">Clinic</h1> <div class="clinic_content">`;
                    clinics.forEach(function(clinic) {
                        console.log(clinic, 'clinic');

                        // Check if clinic.banner_image and clinic.profile_icon are defined
                        if (clinic?.banner_image && clinic?.profile_icon) {
                            // Construct the image URLs based on the response data
                            var bannerImageUrl = 'storage/' + clinic.banner_image.path + clinic.banner_image
                                .name + '.' + clinic.banner_image.extension;
                            var profileIconUrl = 'storage/' + clinic.profile_icon.path + clinic.profile_icon
                                .name + '.' + clinic.profile_icon.extension;
                        } else {
                            // Handle the case where banner_image or profile_icon is undefined
                            bannerImageUrl = ''; // You can set a default URL or an empty string
                            profileIconUrl = ''; // You can set a default URL or an empty string
                        }

                        // Now you can use bannerImageUrl and profileIconUrl in your code

                        cardHtml += `
                <div class="card-clinic">
                    <div class="first-section"><img src="${bannerImageUrl}" class="banner-image" /></div>
                    <div class="second-section">
                        <h4 class="title">${clinic.name}</h4>
                        <img src="${profileIconUrl}" alt="Navigate" class="navigate-image" />
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
                window.location.href = "#"; // Replace 'page4.html' with the path to your booking page
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
                window.location.href = "#"; // Replace 'page11.html' with the path to your referral page
            }

            // Attach click event listener to referral tab
            referralTab.addEventListener("click", handleReferralClick);

            function navigateToPage(pageURL) {
                window.location.href = pageURL;
            }

        });
    </script>

<script>
    $(document).ready(function() {
        let openCard = $(".open-card");
        let rightMessagesBtn = $('.right-messages');
        let headerUserProfile = $(".login_users");
        let openNotificationModal = $("#openNotificationModal");

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

