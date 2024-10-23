@extends('layouts.app')

@section('content')
    <!-- Full-page background with content overlay -->
    <div class="container-fluid position-relative" style="min-height: 100vh; background: url('{{ asset('images/doctor-background.jpg') }}') no-repeat center center; background-size: cover; ">

        <!-- Page content over the background image -->
        <div class="container position-relative" style="z-index: 1;">
            <div class="row">
                <div class="col-md-12">
                    <div class="banner" style="position: relative;">
                        <img src="{{ asset('images/doctor.jpg') }}" alt="Doctor Image" class="img-fluid w-100" style="height: 350px; object-fit: cover;">
                        <div class="overlay-text text-center" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #0e84b5;">
                            <h1 class="display-4">Find Your Doctor</h1>
                            <!-- Booking Steps Section -->
                            <div class="row my-5 text-center text-dark"> <!-- Added text-dark class for black text -->
                                <div class="col-md-12">
                                    <h3 class="text-dark">Book an appointment in just a few steps</h3> <!-- Explicitly set h3 to black -->
                                    <div class="row justify-content-center mt-4">
                                        <div class="col-md-2 mx-3">
                                            <div class="step-box">
                                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">1</div>
                                                <p class="text-dark">Select a Department</p> <!-- Ensure paragraph text is black -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mx-3">
                                            <div class="step-box">
                                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">2</div>
                                                <p class="text-dark">Choose a Doctor</p> <!-- Ensure paragraph text is black -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mx-3">
                                            <div class="step-box">
                                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">3</div>
                                                <p class="text-dark">Pick an Available Time</p> <!-- Ensure paragraph text is black -->
                                            </div>
                                        </div>
                                        <div class="col-md-2 mx-3">
                                            <div class="step-box">
                                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">4</div>
                                                <p class="text-dark">Confirm and Book</p> <!-- Ensure paragraph text is black -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
