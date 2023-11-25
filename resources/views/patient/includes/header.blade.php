<!-- resources/views/includes/header.blade.php -->
  <!-- MESSAGES MODAL Start-->
  @include('patient.modals.messages')
  <!-- MESSAGES MODAL end-->

  <!-- Notification MODAL Start-->
  @include('patient.modals.notification')
  <!-- Notification MODAL end-->
<header class="header flex justify-between items-center bg-white">
    <div class="flex items-center">
        <div class="logo-wrapper">
            <img class="logo" width="134px" height="35px" src="{{ asset('assets/images/logo.png') }}" alt="" />

        </div>
        <div class="flex links-wrapper xs-header-content">
            <div class="link active" style="visibility: hidden">
                <a href="/gp/booked-appointments.html" class="bg-red-500">Booked Appointment</a>
                <div class="bottom-line"></div>
            </div>
            <div class="link">
                <a href="/gp/history.html" style="visibility: hidden">History</a>
                <div class="bottom-line"></div>
            </div>
        </div>
    </div>
    <div class="flex items-center ml-10">
        <!--
        <button class="header-message-icon">
            <span class="message-icon"></span>
            <img class="mes-icon-header" src="{{ asset('assets/images/messages2.svg') }}" alt="message">
        </button>
        -->
        <button class="header-message-icon" id="openNotificationModal">
            <span class="noti-icon"></span>
            <img class="noti-icon-header" src="{{ asset('assets/bell-notification.png') }}" alt="" />
        </button>

        <div class="login_user" style="display: flex; align-items: center; position: relative">
            <div class="circles">
                <img class="user-icon" width="35px" height="35px" src="{{ asset('assets/images/chat-profile.png') }}" alt="" />
            </div>
            <p class="text-grey text-base ml-10 user-name-header user_name_txts">{{ auth()->user()->name  }}</p>
        </div>

        <div class="user_profile_popup" style="position: absolute; top: 0; margin-top: 4.2rem">
            <span onclick="navigateToPage('profile.html')">My Profile</span>
            <span onclick="navigateToPage('/gp/signin.html')">Logout</span>
        </div>
    </div>
</header>
