<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Doctor Appointment System') }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<!-- Navbar -->
@include('layouts.navigation')

<!-- Background image section (can be enabled or disabled in individual views) -->
@hasSection('background_image')
    <div class="container-fluid position-relative" style="min-height: 100vh; background: url('@yield('background_image')') no-repeat center center; background-size: cover;">
        <!-- Dark overlay -->
        <div class="overlay" style="background-color: rgba(0, 0, 0, 0.2); position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>

        <!-- Page content over the background image -->
        <div class="container position-relative" style="z-index: 1;">
            @yield('content')
        </div>
    </div>
@else
    <main class="py-4">
        @yield('content')
    </main>
@endif

@hasSection('booking_steps')
    @yield('booking_steps')
@endif

<!-- Footer -->
<footer class="bg-light text-center text-lg-start">
    <div class="text-center p-3">
        &copy; {{ date('Y') }} Doctor Appointment System - All Rights Reserved
    </div>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@stack('scripts')  <!-- For additional JS -->
</body>
</html>
