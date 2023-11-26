<!DOCTYPE html>
<html>

<head>
    <title>GP Web App</title>
    {{-- <link href="{{ asset('css/public.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet" /> --}}
    <link href="{{ asset('css/doctor.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <!-- Include any other CSS files -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ asset('js/public.js') }}"></script>
    <!-- Include any other JS files -->
</head>

<body>
    <!-- Your layout structure -->
    @yield('content')
</body>
</html>
