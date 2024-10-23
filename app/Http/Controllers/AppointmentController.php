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
    public function getAvailableSlots(Request $request)
    {
        $doctor = Doctor::findOrFail($request->doctor_id);

        // Format the day to match the doctor's schedule (e.g. Monday, Tuesday)
        $dayOfWeek = \Carbon\Carbon::parse($request->day)->format('l');

        $schedules = $doctor->schedules()->where('day_of_week', $dayOfWeek)->get();  // Filter schedules by day of week
        return response()->json($schedules);  // Return schedules for the selected day
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
