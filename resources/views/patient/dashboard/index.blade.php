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

@endsection
