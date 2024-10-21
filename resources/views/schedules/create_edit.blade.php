@extends('admin.layouts.app')
@php
    function requiredField($isRequired = false) {
        return $isRequired ? '<span class="text-danger">*</span>' : '';
    }
@endphp

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4>{{ isset($schedule) ? 'Edit Doctor Schedule' : 'Create Doctor Schedule' }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ isset($schedule) ? route('schedules.update', $schedule->id) : route('schedules.store') }}" method="POST">
                    @csrf
                    @if(isset($schedule))
                        @method('PUT')
                    @endif

                    <!-- Doctor selection (shown doctor who do not have schedule yet)-->
                    <div class="form-group mb-3">
                        <label for="doctor_id" class="form-label">Doctor {!! requiredField(true) !!}</label>
                        <select name="doctor_id" class="form-control" required>
                            <option value="">Select Doctor</option>
                            @foreach($doctorsWithoutSchedule as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Loop through each day of the week to set schedule -->
                    @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <div class="day-schedule border rounded p-3 mb-3">
                            <h5>{{ $day }}'s Schedule{!! requiredField(true) !!}</h5>

                            <!-- Start Time -->
                            <div class="form-group mb-3">
                                <label for="start_time_{{ $day }}" class="form-label">Start Time{!! requiredField(true) !!}</label>
                                <input type="time" name="schedule[{{ $day }}][start_time]" value="{{ old('schedule['.$day.'][start_time]', $schedule->start_time ?? '') }}" required>
                            </div>

                            <!-- End Time -->
                            <div class="form-group mb-3">
                                <label for="end_time_{{ $day }}" class="form-label">End Time{!! requiredField(true) !!}</label>
                                <input type="time" name="schedule[{{ $day }}][end_time]" value="{{ old('schedule['.$day.'][end_time]', $schedule->end_time ?? '') }}" required>
                            </div>


                            <!-- Appointment Duration -->
                            <div class="form-group mb-3">
                                <label for="appointment_duration_{{ $day }}" class="form-label">Appointment Duration (minutes){!! requiredField(true) !!}</label>
                                <input type="number" name="schedule[{{ $day }}][appointment_duration]" class="form-control" min="5" max="120" value="{{ old('schedule.' . $day . '.appointment_duration', isset($schedule[$day]) ? $schedule[$day]['appointment_duration'] : 30) }}" required>
                            </div>

                            <!-- Is Active -->
                            <div class="form-group mb-3">
                                <label for="is_active_{{ $day }}" class="form-label">Is Active{!! requiredField(true) !!}</label>
                                <div class="form-check">
                                    <input type="radio" name="schedule[{{ $day }}][is_active]" class="form-check-input" id="is_active_yes_{{ $day }}" value="1" {{ old('schedule.' . $day . '.is_active', isset($schedule[$day]) && $schedule[$day]['is_active'] ? 'checked' : '') }} required>
                                    <label for="is_active_yes_{{ $day }}" class="form-check-label">Yes</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" name="schedule[{{ $day }}][is_active]" class="form-check-input" id="is_active_no_{{ $day }}" value="0" {{ old('schedule.' . $day . '.is_active', isset($schedule[$day]) && !$schedule[$day]['is_active'] ? 'checked' : '') }} required>
                                    <label for="is_active_no_{{ $day }}" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Back to List</a>
                        <button type="submit" class="btn btn-primary">{{ isset($schedule) ? 'Update Schedule' : 'Create Schedule' }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

