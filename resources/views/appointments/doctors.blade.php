@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    <!-- Include the booking steps partial -->
    @include('partials._booking_steps')

    <!-- Step 2 Heading with Circle -->
    <div class="row justify-content-center mt-4"> <!-- Reduced margin from mt-5 to mt-4 -->
        <div class="col-md-8 text-center">
            <div class="d-flex justify-content-center align-items-center mb-3"> <!-- Reduced margin-bottom -->
                <div class="circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle" style="width: 60px; height: 60px; font-size: 15px;">
                    Step:2
                </div>
                <h2 class="ml-3 mb-0 text-primary">Choose a Doctor</h2>
            </div>
        </div>
    </div>

    <!-- Doctors Section -->
    <div class="row justify-content-center mt-3">
        @foreach($doctors as $doctor)
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm h-100 border-0 rounded d-flex flex-column"> <!-- Added flex-column to make the card content stack vertically -->
                    <img src="{{ asset('images/doctors/' . $doctor->id . '.png') }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/doctors/default-doctor.png') }}';"
                         class="card-img-top" alt="{{ $doctor->name }}" style="height: 200px; object-fit: cover;">

                    <!-- Doctor Details -->
                    <div class="card-body d-flex flex-column text-center p-2">
                        <h6 class="card-title mb-1">{{ $doctor->name }}</h6>
                        <p class="text-muted">{{ $doctor->specialization }}</p>

                        <!-- This div with mt-auto pushes the button to the bottom -->
                        <div class="mt-auto">
                            <a href="{{ route('appointments.availableSlots', $doctor->id) }}" class="btn btn-outline-success btn-lg btn-block">Select Doctor</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <!-- Back to Department Button --><!-- Back to Welcome Button -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-lg">Back to Home</a>
        </div>
    </div>
@endsection
