@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    <!-- Include the booking steps partial -->
    @include('partials._booking_steps')
    <!-- Success Toast Notification -->
    @if(session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055; right: 20px; top: 20px;">
            <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- Step 1 Heading with Circle -->
    <div class="row justify-content-center mt-4"> <!-- Reduced margin-top from mt-5 to mt-4 -->
        <div class="col-md-8 text-center">
            <div class="d-flex justify-content-center align-items-center mb-3"> <!-- Reduced margin-bottom from mb-4 to mb-3 -->
                <div class="circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle" style="width: 60px; height: 60px; font-size: 15px;">
                    Step:1
                </div>
                <h2 class="ml-3 mb-0 text-primary">Select a Department</h2>
            </div>
        </div>
    </div>

    <!-- Department Cards Section -->
    <div class="row justify-content-center mt-3"> <!-- Reduced margin-top from mt-5 to mt-3 -->
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var successToast = new bootstrap.Toast(document.getElementById('successToast'), { delay: 5000 });
        successToast.show();
    });
</script>
