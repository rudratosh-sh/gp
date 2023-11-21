<!DOCTYPE html>
<html>

<head>
    <title>Your Title Here</title>
    <link href="{{ asset('css/doctor.css') }}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet" />
    <!-- Include your CSS files -->
</head>

<body>
    @include('doctor.includes.header')

    <div class="container">
        @yield('content')
    </div>

    @include('doctor.includes.footer')

    <!-- Include your JS files -->
</body>

</html>
