@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    @include('partials._booking_steps')

    <!-- Step 3 Heading with Circle -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 text-center">
            <div class="d-flex justify-content-center align-items-center mb-3">
                <div class="circle bg-primary text-white d-flex justify-content-center align-items-center rounded-circle" style="width: 60px; height: 60px; font-size: 15px;">
                    Step:3
                </div>
                <h2 class="ml-3 mb-0 text-primary">Pick an Available Time Slot</h2>
            </div>
        </div>
    </div>

    <!-- Doctor Information -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-6 text-center">
            <h3>Available Time Slots for Dr. {{ $doctor->name }}</h3>
            <p class="text-muted">{{ $doctor->specialization }}</p>
        </div>
    </div>

    <!-- Available Slots Section -->
    <div class="row justify-content-center">
        @if($doctor->schedules->count() > 0)
            @foreach($doctor->schedules as $schedule)
                <div class="col-6 col-md-4 col-lg-3 mb-3">
                    <div class="card shadow-sm h-100 border-0 rounded text-center">
                        <div class="card-body p-3">
                            <h6 class="card-title mb-2">{{ $schedule->day_of_week }}</h6>
                            <p class="text-muted">
                                From {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}
                                to {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                            </p>
                            <p class="{{ $schedule->available_slots > 0 ? 'text-success' : 'text-danger' }}">
                                {{ $schedule->available_slots }} Tokens Left
                            </p>
                            @if($schedule->available_slots > 0)
                                <select class="form-control mb-2 time-slot-dropdown" id="time-slot-{{ $schedule->id }}" data-schedule-id="{{ $schedule->id }}">
                                    <option value="" disabled selected>Select Time Slot</option>
                                    @foreach($schedule->time_slots as $slot)
                                        <option value="{{ $slot['start'] }}">
                                            {{ $slot['display'] }}
                                        </option>
                                    @endforeach
                                </select>
                                <a href="#" id="select-time-btn-{{ $schedule->id }}" class="btn btn-outline-primary btn-sm" disabled>Select Time for Token</a>
                            @else
                                <p class="text-danger">No Tokens Available</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- Display the "No slots available" message in a card -->
            <div class="col-6 col-md-4 col-lg-3 mb-3">
                <div class="card shadow-sm h-100 border-0 rounded text-center">
                    <div class="card-body p-3">
                        <h6 class="card-title mb-2 text-danger">No available slots</h6>
                        <p class="text-muted">There are no available slots for this doctor at the moment. Please check back later.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Back to Doctors Button -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-6 text-center">
            <a href="{{ route('departments.showDoctors', $doctor->department_id) }}" class="btn btn-outline-secondary btn-lg">Back to Doctors</a>
        </div>
    </div>

    <!-- Add custom JavaScript to handle dynamic link updates -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.time-slot-dropdown').forEach(function (dropdown) {
                dropdown.addEventListener('change', function () {
                    const scheduleId = this.getAttribute('data-schedule-id');
                    const selectedTime = this.value;
                    const doctorId = "{{ $doctor->id }}";
                    const selectButton = document.getElementById('select-time-btn-' + scheduleId);

                    if (selectedTime) {
                        const newHref = `/appointments/registration/${doctorId}/${scheduleId}/${selectedTime}`;
                        selectButton.setAttribute('href', newHref);
                        selectButton.removeAttribute('disabled');
                    }
                });
            });
        });
    </script>
@endsection
