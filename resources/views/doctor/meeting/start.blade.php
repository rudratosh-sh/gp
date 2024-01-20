@extends('patient.layouts.public', ['page_title' => 'List of Appointment'])
@section('content')
    <style type="text/css">
        .bg-gray-900 {
            --tw-bg-opacity: 1;
            background-color: rgb(17 24 39 / var(--tw-bg-opacity));
            border-color: white;
        }

        .space-x-4> :not([hidden])~ :not([hidden]) {
            --tw-space-x-reverse: 0;
            margin-right: calc(1rem * var(--tw-space-x-reverse));
            margin-left: calc(1rem * calc(1 - var(--tw-space-x-reverse)));
        }

        .object-contain {
            -o-object-fit: contain;
            object-fit: contain;
        }

        .rounded-t-3xl {
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        .text-white {
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity));
        }

        .font-bold {
            font-weight: 200;
        }

        .text-center {
            text-align: center;
        }

        .pt-1 {
            padding-top: 0.25rem;
        }

        .bg-gray-700 {
            --tw-bg-opacity: 1;
            background-color: rgb(55 65 81 / var(--tw-bg-opacity));
        }

        .rounded-b-3xl {
            border-bottom-right-radius: 1.5rem;
            border-bottom-left-radius: 1.5rem;
        }

        .w-full {
            width: 100%;
        }

        .h-8 {
            height: 2rem;
        }

        .bottom-0 {
            bottom: 0px;
        }

        .absolute {
            position: absolute;
        }

        img,
        video {
            max-width: 100%;
            height: auto;
        }

        .live-video-second {
            width: 300px !important;
        }

        .second-vid-height {
            height: 149px;
        }

        .local-part-border {
            border: 1px solid white;
            height: 200px;
            border-radius: 25px;
        }
    </style>
    <div class="container">
        <!-- HEADER -->
        @include('patient.includes.header')
        <div class="space_container">
            <!-- SIDE BAR -->
            <ul class="sidebar" style="display: none">
                <li class="active" id="dashboard-tab"><a style="all:unset"
                        class="a-tab-active"href="{{ route('appointment.schedule.list') }}">Dashboard</a></li>
                <li id="booking-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('appointment.index.get') }}">Booking Appointment</a></li>
                <li id="referral-tab"><a style="all:unset" class="a-tab-inactive"
                        href="{{ route('referal.index.get') }}">Referral Letter</a></li>
                <li id="profile-tab"><a style="all:unset"class="a-tab-inactive" href="{{ route('patient.profile.get') }}">My
                        Profile</a></li>
            </ul>
            <!-- Main Content -->
            <div class="dis_flx_full">
                <section class="bg-grey1 patient-detail-wrapper">
                    <div class="">
                        <div class="flx_space_btw">
                            <div class="flex items-center">
                                <img class="pointer" width="40px" height="40px"
                                    src="/assets/images/arrow-left-purple.svg" alt="" />
                                <p class="text-grey2 text-22 font-bold ml-10">Patient Details > Video call</p>
                            </div>
                        </div>
                        <div class="video-call-wrapper mt-11">
                            <div id="activeSpeakerContainer"
                                class=" bg-gray-900 rounded-3xl flex-1 flex relative live-video-first">
                                <video id="activeSpeakerVideo" src="" autoplay
                                    class=" object-contain w-full rounded-t-3xl"></video>
                                <div id="activeSpeakerUsername"
                                    class="hidden absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">
                                </div>
                            </div>
                            <div id="remoteParticipantContainer" class="flex flex-col space-y-4 live-video-second">
                                <div id="localParticiapntContainer"
                                    class="w-48 h-48 rounded-3xl bg-gray-900 relative local-part-border">
                                    <video id="localVideoTag" src="" autoplay
                                        class="object-contain w-full rounded-t-3xl"></video>
                                    <div id="localUsername"
                                        class="absolute h-8 w-full bg-gray-700 rounded-b-3xl bottom-0 text-white text-center font-bold pt-1">
                                        Me
                                    </div>
                                </div>
                            </div>
                            <div class="video-call-btn-actions flex items-center">
                                <div onclick="toggleVideo()" id="video-btn" class="text-center video-btn">
                                    <img id="toggleCamera" width="30px" height="30px" src="/assets/video.png"
                                        alt="" />
                                    <p id="status-text" class="text-grey3 text-xs font-normal">Turn off</p>
                                </div>
                                <div onclick="toggleMic()" class="text-center video-btn">
                                    <img id="toggleMicrophone" width="30px" height="30px" src="/assets/mute.png"
                                        alt="" />
                                    <p id="mic-text" class="text-grey3 text-xs font-normal">Mute</p>
                                </div>
                                <div onclick="toggleScreenCast()" class="text-center video-btn">
                                    <img id="toggleScreen" width="30px" height="30px" src="/assets/cast.png"
                                        alt="" />
                                    <p id="cast-text" class="text-grey3 text-xs font-normal">Start Casting</p>
                                </div>
                                <div id="leave-btn" class="text-center video-btn">
                                    <img id="leaveMeetingR" width="30px" height="30px" src="/assets/logout.png"
                                        alt="" />
                                    <p class="text-grey3 text-xs font-normal">Leave</p>
                                </div>
                                <button id='joinMeetingBtn' style="display:none"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Join Meeting
                                </button>
                                <input type="hidden" id="username" value="{{ $user->name }}" />
                            </div>
                        </div>
                    </div>
                </section>
                <div class="overlay close"></div>
            </div>
        </div>
        <div class="bottom-menu-wrapper">
            <div class="b-menu"><img src="{{ asset('assets/images/menu1.png') }}" alt="Menu 1"></div>
            <div class="b-menu active"><img src="{{ asset('assets/images/menu2.png') }}" alt="Menu 2"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu3.png') }}" alt="Menu 3"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu4.png') }}" alt="Menu 4"></div>
            <div class="b-menu"><img src="{{ asset('assets/images/menu5.png') }}" alt="Menu 5"></div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Refresh the page once after it has loaded
        // if (!sessionStorage.getItem('reloaded')) {
        //     sessionStorage.setItem('reloaded', 'true');
        //     window.onload = function() {
        //         window.location.reload();
        //     };
        // }
        function toggleVideo() {
            var videoImg = document.getElementById("toggleCamera");
            var statusText = document.getElementById("status-text");

            if (videoImg.src.endsWith("video.png")) {
                videoImg.src = "/assets/zoom.png"; // Change to the off image path
                statusText.innerText = "Turn on";
            } else {
                videoImg.src = "/assets/video.png"; // Change to the on image path
                statusText.innerText = "Turn off";
            }
        }

        function toggleMic() {
            var videoImg = document.getElementById("toggleMicrophone");
            var statusText = document.getElementById("mic-text");

            if (videoImg.src.endsWith("mute.png")) {
                videoImg.src = "/assets/mic.png"; // Change to the off image path
                statusText.innerText = "Unmute";
            } else {
                videoImg.src = "/assets/mute.png"; // Change to the on image path
                statusText.innerText = "Mute";
            }
        }

        function toggleScreenCast() {
            var castImg = document.getElementById("toggleScreen");
            var statusText = document.getElementById("cast-text");

            if (castImg.src.endsWith("uncast.png")) {
                castImg.src = "/assets/cast.png";
                statusText.innerText = "Stop Casting";
            } else {
                castImg.src = "/assets/cast.png";
                statusText.innerText = "Start Casting";
            }
        }
        $(document).ready(function() {
            $("#joinMeetingBtn").click();
            $('#leaveMeetingR').on('click', function() {
                window.location.href = '/patient';
            });
        });
    </script>
@endsection
