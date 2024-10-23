@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    <!-- Include the booking steps partial -->
    @include('partials._booking_steps')

    <!-- Department Cards Section -->
    <div class="row justify-content-center mt-5">
        @foreach($departments as $department)
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm h-100 border-0 rounded">
                    <img src="{{ asset('images/departments/' . $department->id . '.png') }}"
                         onerror="this.onerror=null;this.src='{{ asset('images/departments/default-department.png') }}';"
                         class="card-img-top" alt="{{ $department->name }}" style="height: 120px; object-fit: cover;">
                    <div class="card-body text-center p-2">
                        <h6 class="card-title mb-1">{{ $department->name }}</h6>
                        <a href="{{ route('departments.showDoctors', $department->id) }}" class="btn btn-outline-secondary btn-sm">Consult Now</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
