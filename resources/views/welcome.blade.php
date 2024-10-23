@extends('layouts.app')

@section('content')
    <!-- Full-page background with content overlay -->
    <div class="container-fluid position-relative" style="min-height: 100vh; background: url('{{ asset('images/doctor-background.jpg') }}') no-repeat center center; background-size: cover;">

        <!-- Page content over the background image -->
        <div class="container position-relative" style="z-index: 1;">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner" style="position: relative;">
                        <img src="{{ asset('images/doctor.jpg') }}" alt="Doctor Image" class="img-fluid w-100" style="height: 350px; object-fit: cover;">
                        <div class="overlay-text text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #0e84b5;">
                            <h1 class="display-4">Find Your Doctor</h1>
                            <p class="lead ">Book an appointment in just a few steps</p>

                            <!-- Booking Steps Section -->
                            <div class="row justify-content-center mt-4 text-dark">
                                @foreach (['Select a Department', 'Choose a Doctor', 'Pick an Available Time', 'Patient Registration', 'Confirm and Book'] as $index => $step)
                                    <div class="col-6 col-md-2 mx-2"> <!-- Adjusted column width and spacing -->
                                        <div class="step-box">
                                            <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">
                                                {{ $index + 1 }}
                                            </div>
                                            <p class="text-dark">{{ $step }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <!-- End Booking Steps Section -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Department Cards Section -->
            <div class="row justify-content-center mt-5">
                @foreach($departments as $department)
                    <div class="col-6 col-md-4 col-lg-3 mb-3">
                        <div class="card shadow-sm h-100 border-0 rounded">
                            <!-- Display department-specific image or default image -->
                            <img src="{{ asset('images/departments/' . $department->id . '.png') }}"
                                 onerror="this.onerror=null;this.src='{{ asset('images/departments/default-department.png') }}';"
                                 class="card-img-top" alt="{{ $department->name }}" style="height: 120px; object-fit: cover;">
                            <div class="card-body text-center p-2">
                                <h6 class="card-title mb-1">{{ $department->name }}</h6>
                                <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline-secondary btn-sm">Consult Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
