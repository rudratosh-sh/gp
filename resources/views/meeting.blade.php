<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Meta tags, title, and other imports -->

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts and other scripts -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

    <div class="container-fluid px-0">
        <div id="waitingArea" class="max-h-screen p-4">
            <h1 class="text-2xl">Meeting Lobby</h1>
            <div class="container-lg d-flex flex-column gap-4">
                <div class="d-flex justify-content-center bg-secondary rounded-3">
                    <video id='waitingAreaLocalVideo' class="h-96" autoplay muted></video>
                </div>
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <button id='waitingAreaToggleMicrophone' class="btn btn-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <!-- Microphone SVG -->
                        </svg>
                    </button>
                    <button id='waitingAreaToggleCamera' class="btn btn-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <!-- Camera SVG -->
                        </svg>
                    </button>
                </div>
                <div class="d-flex flex-column gap-4 gap-2 text-sm">
                    <div class="d-flex gap-2 align-items-center">
                        <label class="d-flex align-items-center">
                            Name:
                            <input class="form-control form-control-sm" id="username" type="text"
                                placeholder="Name" />
                        </label>
                        <label class="d-flex align-items-center">
                            Camera:
                            <select class="form-select form-select-sm" id='cameraSelectBox'>
                            </select>
                        </label>
                        <label class="d-flex align-items-center">
                            Microphone:
                            <select class="form-select form-select-sm" id='microphoneSelectBox'>
                            </select>
                        </label>
                    </div>
                    <div>
                        <button id='joinMeetingBtn' class="btn btn-primary">
                            Join Meeting
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id='meetingView' class="hidden d-flex flex-wrap gap-4 p-4">
        <div id="activeSpeakerContainer"
            class="bg-dark text-white rounded-3 flex-grow-1 d-flex flex-column position-relative">
            <video id="activeSpeakerVideo" src="" autoplay class="w-100 rounded-top-3"></video>
            <div id="activeSpeakerUsername"
                class="hidden position-absolute w-100 bg-secondary rounded-bottom-3 text-center font-weight-bold pt-1 text-white bottom-0">

            </div>
        </div>

        <div id="remoteParticipantContainer" class="d-flex flex-column gap-4">
            <div id="localParticiapntContainer" class="w-48 h-48 bg-dark text-white rounded-3 position-relative">
                <video id="localVideoTag" src="" autoplay class="w-100 rounded-top-3"></video>
                <div id="localUsername"
                    class="position-absolute w-100 bg-secondary rounded-bottom-3 text-center font-weight-bold pt-1 text-white bottom-0">
                    Me
                </div>
            </div>
        </div>

        <div class="flex flex-col space-y-2">
            <button id='toggleMicrophone' class="bg-gray-400 w-10 h-10 rounded-md p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                    </path>
                </svg>
            </button>

            <button id='toggleCamera' class="bg-gray-400 w-10 h-10 rounded-md p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                    </path>
                </svg>
            </button>

            <button id='toggleScreen' class="bg-gray-400 w-10 h-10 rounded-md p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </button>

            <button id='leaveMeeting' class="bg-red-400 text-white w-10 h-10 rounded-md p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                    </path>
                </svg>
            </button>

        </div>
    </div>

    <div id="leaveMeetingView" class="hidden">
        <h1 class="text-center text-3xl mt-10 font-bold">
            You have left the meeting
        </h1>
    </div>
</body>

</html>
