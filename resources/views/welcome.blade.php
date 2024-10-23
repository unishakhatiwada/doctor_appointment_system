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
                            <p class="lead">Book an appointment in just a few steps</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Booking Steps Section -->
            <div class="row my-5 text-center text-black">
                <div class="col-md-12">
                    <h3>How to Book an Appointment</h3>
                    <div class="row justify-content-center mt-4">
                        <div class="col-md-2">
                            <div class="step-box">
                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">1</div>
                                <p>Select a Department</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="step-box">
                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">2</div>
                                <p>Choose a Doctor</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="step-box">
                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">3</div>
                                <p>Pick an Available Time</p>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="step-box">
                                <div class="circle bg-primary text-white rounded-circle mx-auto mb-2 d-flex justify-content-center align-items-center" style="width: 60px; height: 60px;">4</div>
                                <p>Confirm and Book</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Department Cards Section -->
            <div class="row justify-content-center mt-5">
                @foreach($departments as $department)
                    <div class="col-6 col-md-4 col-lg-3 mb-3"> <!-- Adjusted to fit four cards in a row on larger screens -->
                        <div class="card shadow-sm h-100 border-0 rounded">
                            <img src="{{ $department->image }}" class="card-img-top" alt="{{ $department->name }}" style="height: 120px; object-fit: cover;"> <!-- Reduced image height -->
                            <div class="card-body text-center p-2"> <!-- Reduced padding inside the card -->
                                <h6 class="card-title mb-1">{{ $department->name }}</h6> <!-- Reduced the heading size and margin for a compact look -->
                                <a href="{{ route('departments.show', $department->id) }}" class="btn btn-outline-secondary btn-sm">Consult Now</a> <!-- Smaller button size -->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endsection
