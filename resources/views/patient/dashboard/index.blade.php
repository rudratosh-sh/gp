@extends('patient.layouts.public')

@section('content')
    <div class="container">
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
            <div class="dis_flx_pg3">
                <div class="content_container_pg3">
                    <h4 class="welcome_txt_pg3">Welcome Sean</h4>
                    <h2 class="titlep_g3">You’r Successfully Signed Up</h2>
                    <div class="login_btn_pg3">
                        <a class="login_pg3" href="{{ route('appointment.index.get') }}">Book an Appointment</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button id="sendNotificationBtn">Send Notification</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            let openCard = $(".open-card");
            let rightMessagesBtn = $('.right-messages');
            let headerUserProfile = $(".login_user");
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

        document.getElementById('sendNotificationBtn').addEventListener('click', function() {
            // Send AJAX request to trigger notification
            fetch('/send-notification')
                .then(response => response.text())
                .then(data => {
                    console.log('Notification sent:', data);
                })
                .catch(error => {
                    console.error('Error sending notification:', error);
                });
        });
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        window.onload = function() {
            console.log('Echo instance:', Echo);

            Echo.channel('app-test')
                .listen('.NotificationEvent', (data) => {
                    console.log('Received data:', data); // Ensure this line logs the data correctly

                    // Rest of your code to display notifications...
                })
                .error((error) => {
                    console.error('Echo error:', error);
                })
                .listenForWhisper('typing', (e) => {
                    console.log('Whisper event:', e);
                });
        };
    </script>
@endsection
