@extends('admin.layouts.app')

@php
    use Carbon\Carbon;
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

                    <!-- Doctor selection -->
                    <div class="form-group mb-3">
                        <label for="doctor_id" class="form-label">Doctor {!! requiredField(true) !!}</label>

                        @if(isset($schedule))
                            <!-- Edit Mode: Show doctor name in a disabled select field -->
                            <select name="doctor_id" class="form-control" disabled>
                                <option value="{{ $schedule->doctor->id }}">{{ $schedule->doctor->name }}</option>
                            </select>
                            <!-- Keep the doctor_id as a hidden field to submit -->
                            <input type="hidden" name="doctor_id" value="{{ $schedule->doctor->id }}">
                        @else
                            <!-- Create Mode: Show doctor dropdown for selection -->
                            <select name="doctor_id" class="form-control" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctorsWithoutSchedule as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>


                    <!-- Add a button to copy Sunday’s schedule to the rest of the weekdays -->
                    <button type="button" id="copy-sunday-btn" class="btn btn-secondary mb-3">Copy Sunday Schedule to Weekdays</button>

                    <!-- Loop through each day of the week to set schedule -->
                    @foreach(['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                        <div class="day-schedule border rounded p-3 mb-3">
                            <h5>{{ $day }}'s Schedule</h5>

                            <!-- Start Time -->
                            <div class="form-group mb-3">
                                <label for="start_time_{{ $day }}" class="form-label">Start Time</label>
                                <input type="time" name="schedule[{{ $day }}][start_time]" id="start_time_{{ $day }}"
                                       value="{{ old('schedule['.$day.'][start_time]', isset($schedules[$day]) ? Carbon::createFromFormat('H:i:s', $schedules[$day]->start_time)->format('H:i') : '') }}" required>
                            </div>

                            <!-- End Time -->
                            <div class="form-group mb-3">
                                <label for="end_time_{{ $day }}" class="form-label">End Time</label>
                                <input type="time" name="schedule[{{ $day }}][end_time]" id="end_time_{{ $day }}"
                                       value="{{ old('schedule['.$day.'][end_time]', isset($schedules[$day]) ? Carbon::createFromFormat('H:i:s', $schedules[$day]->end_time)->format('H:i') : '') }}" required>
                            </div>

                            <!-- Appointment Duration -->
                            <div class="form-group mb-3">
                                <label for="appointment_duration_{{ $day }}" class="form-label">Appointment Duration (minutes)</label>
                                <select name="schedule[{{ $day }}][appointment_duration]" class="form-control" required>
                                    <option value="15" {{ old('schedule['.$day.'][appointment_duration]', $schedules[$day]->appointment_duration ?? 15) == 15 ? 'selected' : '' }}>15</option>
                                    <option value="30" {{ old('schedule['.$day.'][appointment_duration]', $schedules[$day]->appointment_duration ?? 30) == 30 ? 'selected' : '' }}>30</option>
                                    <option value="45" {{ old('schedule['.$day.'][appointment_duration]', $schedules[$day]->appointment_duration ?? 45) == 45 ? 'selected' : '' }}>45</option>
                                    <option value="60" {{ old('schedule['.$day.'][appointment_duration]', $schedules[$day]->appointment_duration ?? 60) == 60 ? 'selected' : '' }}>60</option>
                                </select>
                            </div>

                            <!-- Is Active -->
                            <div class="form-group mb-3">
                                <label for="is_active_{{ $day }}" class="form-label">Is Active</label>
                                <div class="form-check">
                                    <input type="radio" name="schedule[{{ $day }}][is_active]" class="form-check-input" id="is_active_yes_{{ $day }}" value="1"
                                        {{ old('schedule['.$day.'][is_active]', $schedules[$day]->is_active ?? '') == 1 ? 'checked' : '' }}>
                                    <label for="is_active_yes_{{ $day }}" class="form-check-label">Yes</label>
                                </div>

                                <div class="form-check">
                                    <input type="radio" name="schedule[{{ $day }}][is_active]" class="form-check-input" id="is_active_no_{{ $day }}" value="0"
                                        {{ old('schedule['.$day.'][is_active]', $schedules[$day]->is_active ?? '') == 0 ? 'checked' : '' }}>
                                    <label for="is_active_no_{{ $day }}" class="form-check-label">No</label>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <script>
                        // Copy Sunday’s schedule to weekdays
                        document.getElementById('copy-sunday-btn').addEventListener('click', function() {
                            let sundayStart = document.getElementById('start_time_Sunday').value;
                            let sundayEnd = document.getElementById('end_time_Sunday').value;
                            let sundayDuration = document.querySelector('select[name="schedule[Sunday][appointment_duration]"]').value;

                            ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'].forEach(day => {
                                document.getElementById(`start_time_${day}`).value = sundayStart;
                                document.getElementById(`end_time_${day}`).value = sundayEnd;
                                document.querySelector(`select[name="schedule[${day}][appointment_duration]"]`).value = sundayDuration;
                            });
                        });
                    </script>
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
