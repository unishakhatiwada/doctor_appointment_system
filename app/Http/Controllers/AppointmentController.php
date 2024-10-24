<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{

    // Display available departments and doctors
    public function create()
    {
        $departments = Department::all();  // Get all departments
        return view('appointments.create', compact('departments'));
    }

    // Display available doctors in a department
    public function getDoctors($departmentId)
    {
        // Fetch the department and doctors
        $department = Department::findOrFail($departmentId);
        $doctors = Doctor::where('department_id', $departmentId)->get();

        // Return the view with the data
        return view('appointments.doctors', compact('department', 'doctors'));
    }

    // Display available time slots for a doctor on a specific day
    public function availableSlots($doctorId)
    {
        // Fetch doctor and active schedules with their appointments (eager load to avoid N+1 problem)
        $doctor = Doctor::with(['schedules' => function($query) {
            $query->where('is_active', true);
        }, 'schedules.appointments'])->findOrFail($doctorId);

        // Loop through each schedule and calculate available slots
        foreach ($doctor->schedules as $schedule) {
            // Parse start and end times once
            $startTime = \Carbon\Carbon::parse($schedule->start_time);
            $endTime = \Carbon\Carbon::parse($schedule->end_time);

            // Calculate total duration in minutes
            $totalDurationInMinutes = $startTime->diffInMinutes($endTime);

            // Check if appointment duration is valid and calculate total slots and available slots
            if ($schedule->appointment_duration > 0) {
                $totalSlots = floor($totalDurationInMinutes / $schedule->appointment_duration);
                $bookedAppointments = $schedule->appointments->count(); // Eager loaded count
                $availableSlots = max(0, $totalSlots - $bookedAppointments);
            } else {
                $availableSlots = 0;
            }

            // Attach available slots directly to the schedule model
            $schedule->available_slots = $availableSlots;
        }

        // Return the view with the doctor and schedules
        return view('appointments.available_slots', compact('doctor'));
    }

    public function store(AppointmentRequest $request)
    {
        $validated = $request->validated();

        // Check if the doctor is already booked at the same time
        $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where('appointment_time', $validated['appointment_time'])
            ->first();

        if ($existingAppointment) {
            return redirect()->back()->with('error', 'The doctor is already booked at this time.');
        }

         Appointment::create([
            'user_id' => Auth::id(),
            'doctor_id' => $validated['doctor_id'],
            'schedule_id' => $validated['schedule_id'],
            'appointment_date' => $validated['appointment_date'],
            'appointment_time' => $validated['appointment_time'],
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked successfully!');
    }
}
