<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentRequest;
use App\Mail\AppointmentConfirmationMail;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    // Display available departments and doctors
    public function create()
    {
        $departments = Department::all();  // Get all departments

        return view('welcome', compact('departments'));
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
        // Fetch active doctor schedules and their appointments
        $doctor = Doctor::with(['schedules' => function ($query) {
            $query->where('is_active', true); // Only active schedules
        }, 'schedules.appointments'])->findOrFail($doctorId);

        $gapDuration = 2; // 2-minute gap between each slot

        foreach ($doctor->schedules as $schedule) {
            $startTime = \Carbon\Carbon::parse($schedule->start_time);
            $endTime = \Carbon\Carbon::parse($schedule->end_time);
            $appointmentDuration = $schedule->appointment_duration;

            // Calculate total slots based on duration
            $totalDurationInMinutes = $startTime->diffInMinutes($endTime);
            $totalSlots = floor($totalDurationInMinutes / ($appointmentDuration + $gapDuration));

            // Get all booked times for this schedule (appointments)
            $bookedTimes = $schedule->appointments->map(function ($appointment) use ($appointmentDuration) {
                return [
                    'start' => \Carbon\Carbon::parse($appointment->start_time),
                    'end' => \Carbon\Carbon::parse($appointment->end_time)->addMinutes($appointmentDuration),
                ];
            });

            // Initialize available time slots with gap interval
            $timeSlots = [];
            $slotStartTime = clone $startTime;
            $availableSlots = 0;

            // Generate slots until end time is reached or total slots are filled
            while ($slotStartTime->lt($endTime) && $availableSlots < $totalSlots) {
                $slotEndTime = $slotStartTime->copy()->addMinutes($appointmentDuration);

                // Check for overlap with booked appointments
                $isBooked = $bookedTimes->contains(function ($booked) use ($slotStartTime, $slotEndTime) {
                    return $slotStartTime->lt($booked['end']) && $slotEndTime->gt($booked['start']);
                });
                // Only add the slot if it is not booked
                if (! $isBooked) {
                    $timeSlots[] = [
                        'start' => $slotStartTime->format('H:i'),
                        'display' => $slotStartTime->format('g:i A').' - '.$slotEndTime->format('g:i A'),
                    ];
                    $availableSlots++; // Increment available slot counter
                }

                // Move to the next available slot with gap duration
                $slotStartTime->addMinutes($appointmentDuration + $gapDuration);
            }

            // Attach available slots and time slots to schedule
            $schedule->setAttribute('available_slots', $availableSlots);
            $schedule->setAttribute('time_slots', $timeSlots);
        }

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
        $validated = $request->validated();
        $startTime = \Carbon\Carbon::parse($validated['start_time'])->format('H:i:s');
        $endTime = \Carbon\Carbon::parse($validated['end_time'])->format('H:i:s');

        // Check for overlapping appointments
        $overlapExists = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                            ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($overlapExists) {
            return redirect()->back()->with('error', 'The doctor is already booked at this time.');
        }

        DB::beginTransaction();

        try {
            // Create or retrieve patient information
            $patient = Patient::firstOrCreate(
                ['email' => $validated['email']],
                array_merge($validated, [
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                ])
            );

            // Create the appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $validated['doctor_id'],
                'schedule_id' => $validated['schedule_id'],
                'appointment_date' => $validated['appointment_date'],
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            // Send email confirmation
            Mail::to($patient->email)->send(new AppointmentConfirmationMail($appointment));

            // Commit the transaction only if email is sent successfully
            DB::commit();

            // Redirect to the welcome page with success message
            return redirect()->route('appointments.create')->with('success', 'Your appointment has been successfully booked! Please check your Mail');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error booking appointment or sending email: '.$e->getMessage());

            return redirect()->back()->with('error', 'There was an error booking your appointment.');
        }
    }
}
