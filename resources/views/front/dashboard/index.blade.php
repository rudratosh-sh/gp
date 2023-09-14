@extends('front.layouts.public')

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
                    <h4 class="user_name_txt">{{$user->name}}</h4>
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
@endsection
