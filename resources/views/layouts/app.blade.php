<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Medical Appointment System') }}</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand text-blue" href="{{ url('/') }}">Doctor Appointment System</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('departments.index') }}">Departments</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('doctors.index') }}">Doctors</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('appointments.create') }}">My Appointments</a>
            </li>
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile.edit') }}">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            @endguest
        </ul>
    </div>
</nav>

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
