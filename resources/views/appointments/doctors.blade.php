@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    <!-- Include the booking steps partial -->
    @include('partials._booking_steps')

    <!-- Doctors Section -->
    <div class="row justify-content-center mt-5">
        @foreach($doctors as $doctor)
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm h-100 border-0 rounded">
                    <img src="{{ asset('images/doctors/' . $doctor->id . '.png') }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/doctors/default-doctor.png') }}';"
                         class="card-img-top" alt="{{ $doctor->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center p-2">
                        <h6 class="card-title mb-1">{{ $doctor->name }}</h6>
                        <p class="text-muted">{{ $doctor->specialization }}</p>
                        <a href="#" class="btn btn-outline-success btn-sm">Select</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
