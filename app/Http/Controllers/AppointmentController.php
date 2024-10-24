<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
    public function showRegistrationForm($doctorId, $scheduleId, $time)
    {
        $doctor = Doctor::findOrFail($doctorId);
        $schedule = Schedule::findOrFail($scheduleId);
        $appointment_date = \Carbon\Carbon::now()->next($schedule->day_of_week);
        // Pass the data to the registration view
        return view('appointments.registration', compact('doctor', 'schedule', 'time', 'appointment_date'));
    }

    public function store(AppointmentRequest $request)
    {
        // Validate the input data
        $validated = $request->validated();

        // Use a database transaction to ensure atomicity
        DB::beginTransaction();

        try {
            // Check if the doctor is already booked for the selected time and date
            $existingAppointment = Appointment::where('doctor_id', $validated['doctor_id'])
                ->where('appointment_date', $validated['appointment_date'])
                ->where('appointment_time', $validated['appointment_time'])
                ->first();

            if ($existingAppointment) {
                // Rollback the transaction and redirect with an error message
                DB::rollBack();
                return redirect()->back()->with('error', 'The doctor is already booked at this time.');
            }

            // Check if the patient already exists based on the email
            $patient = Patient::where('email', $validated['email'])->first();

            // If the patient does not exist, create a new patient
            if (!$patient) {
                $patient = Patient::create([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'email' => $validated['email'],
                    'gender' => $validated['gender'],
                    'age' => $validated['age'],
                    'phone' => $validated['phone'],
                ]);
            }

            // Create a new appointment with the validated data
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validated['doctor_id'],
                'schedule_id' => $validated['schedule_id'],
                'appointment_date' => $validated['appointment_date'],
                'appointment_time' => $validated['appointment_time'],
            ]);

            // Commit the transaction
            DB::commit();

            // Redirect the user to the confirmation page with a success message
            return redirect()->route('appointments.confirmation', $appointment->id)
                ->with('success', 'Your appointment has been successfully booked!');

        } catch (Exception $e) {
            // If something went wrong, rollback the transaction
            DB::rollBack();
            // Log the error for debugging (optional)
            \Log::error('Appointment booking failed: ' . $e->getMessage());

            // Redirect back with an error message
            return redirect()->back()->with('error', 'There was an error processing your appointment. Please try again.');
        }
    }

    public function confirmation(Appointment $appointment): View
    {
        return view('appointments.confirmation', compact('appointment'));
    }
}
