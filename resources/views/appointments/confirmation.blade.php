<!-- resources/views/appointments/confirmation.blade.php -->

@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body p-4">
                        <!-- Success Message -->
                        <h3 class="card-title mb-4 text-center text-success">Appointment Confirmed!</h3>

                        <!-- Appointment Details -->
                        <p class="text-center">Your appointment has been confirmed successfully.</p>

                        <!-- Doctor Information -->
                        <h5 class="text-center">Dr. {{ $appointment->doctor->name }}</h5>
                        <p class="text-center text-muted">{{ $appointment->doctor->specialization }}</p>

                        <!-- Time Slot Information -->
                        <p class="text-center">
                            Appointment Date: {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}<br>
                            Time Slot: {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($appointment->appointment_time)->addMinutes($appointment->schedule->appointment_duration)->format('g:i A') }}
                        </p>

                        <!-- Patient Information -->
                        <h6 class="text-center">Patient Information</h6>
                        <p class="text-center">
                            Name: {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}<br>
                            Age: {{ $appointment->patient->age }}<br>
                            Gender: {{ ucfirst($appointment->patient->gender) }}<br>
                            Email: {{ $appointment->patient->email }}<br>
                            Phone: {{ $appointment->patient->phone }}
                        </p>

                        <!-- Back to Appointments Button -->
                        <div class="text-center mt-4">
                            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Back to Appointments</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
