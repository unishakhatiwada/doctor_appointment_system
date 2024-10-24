@extends('layouts.app')

@section('background_image', asset('images/doctor-background.jpg'))

@section('content')
    @include('partials._booking_steps')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded">
                    <div class="card-body p-4">
                        <!-- Heading -->
                        <h3 class="card-title mb-4 text-center">Confirm Your Appointment</h3>

                        <!-- Doctor and Time Slot Information -->
                        <p class="text-center">Dr. {{ $doctor->name }} | Time Slot: {{ \Carbon\Carbon::parse($time)->format('g:i A') }} -
                            {{ \Carbon\Carbon::parse($time)->addMinutes($schedule->appointment_duration)->format('g:i A') }}</p>

                        <!-- Show validation error message -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Back to Time Slots Button -->
                        <div class="text-center mb-4">
                            <a href="{{ route('appointments.availableSlots', $doctor->id) }}" class="btn btn-outline-secondary">
                                Back to Time Slots
                            </a>
                        </div>

                        <!-- Patient details form -->
                        <form action="{{ route('appointments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                            <input type="hidden" name="appointment_time" value="{{ $time }}">
                            <input type="hidden" name="appointment_date" value="{{ $appointment_date }}">

                            <div class="form-group">
                                <label for="first_name">First Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                @error('first_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="last_name">Last Name<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email<span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="age">Age<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="age" name="age" value="{{ old('age') }}" required>
                                @error('age')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender<span class="text-danger">*</span></label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Confirm Appointment</button>
                        </form>
                        <!-- Back to Time Slots Button -->
                        <div class="text-center mb-4">
                            <a href="{{ route('appointments.availableSlots', $doctor->id) }}" class="btn btn-outline-secondary">
                                Back to Time Slots
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
