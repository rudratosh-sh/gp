<!DOCTYPE html>
<html>

<head>
    <title>{{ $page_title }}</title>
    <link href="{{ asset('css/doctor.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Toastr -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script> <!-- Include any other CSS files -->
    <meta name="csrf-token" content="{{ csrf_token() }}" /> <!-- Include your CSS files -->

    <script src="https://cdn.metered.ca/sdk/video/1.4.5/sdk.min.js"></script>
    <script>
        window.METERED_DOMAIN = "{{ $METERED_DOMAIN ?? '' }}";
        window.MEETING_ID = "{{ $MEETING_ID ?? '' }}";
    </script>
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @include('doctor.includes.header', ['active' => $active ?? ''])

    <div class="">
        @yield('content')
    </div>

    @include('doctor.includes.footer')

    <!-- Include your JS files -->
</body>

</html>
