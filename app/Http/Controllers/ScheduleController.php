<?php

namespace App\Http\Controllers;

use App\DataTables\SchedulesDataTable;
use App\Http\Requests\ScheduleRequest;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    public function index(SchedulesDataTable $dataTable)
    {
        return $dataTable->render('schedules.index');
    }

    public function create(): View
    {
        // Fetch doctors who do not have any schedules
        $doctorsWithoutSchedule = Doctor::doesntHave('schedules')->get();

        return view('schedules.create_edit', compact('doctorsWithoutSchedule'));
    }

    public function store(ScheduleRequest $request): RedirectResponse
    {
        // Retrieve validated input data
        $validated = $request->validated();
        $doctorId = $validated['doctor_id']; // Same doctor ID for all schedules

        // Using transaction to ensure all schedules are created together
        DB::transaction(function () use ($validated, $doctorId) {
            // Iterate through each day of the week to create the schedule
            foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
                // Only store the schedule if start_time and end_time are provided
                if (! empty($validated['schedule'][$day]['start_time']) && ! empty($validated['schedule'][$day]['end_time'])) {
                    Schedule::create([
                        'doctor_id' => $doctorId,
                        'day_of_week' => $day,
                        'start_time' => $validated['schedule'][$day]['start_time'],
                        'end_time' => $validated['schedule'][$day]['end_time'],
                        'appointment_duration' => $validated['schedule'][$day]['appointment_duration'],
                        'is_active' => $validated['schedule'][$day]['is_active'] ?? false, // Default to false if not provided
                    ]);
                }
            }
        });

        // Redirect back to schedule index with a success message
        return redirect()->route('schedules.index')->with('success', 'Doctor schedule created successfully for the entire week.');
    }

    public function edit(Schedule $schedule): View
    {
        // Only pass the current doctor linked to the schedule
        $doctor = $schedule->doctor;

        return view('schedules.create_edit', compact('doctor', 'schedule'));
    }

    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        // Get validated data from the request
        $validated = $request->validated();

        // Update the doctor_id only once (since it applies to all schedules)
        $doctor_id = $validated['doctor_id'];

        // Iterate over each day's schedule and update it
        foreach ($validated['schedule'] as $day => $daySchedule) {
            // Check if the doctor already has a schedule for this day
            $scheduleRecord = Schedule::where('doctor_id', $doctor_id)
                ->where('day_of_week', $day)
                ->first();

            if ($scheduleRecord) {
                // Update the existing schedule
                $scheduleRecord->update([
                    'start_time' => $daySchedule['start_time'],
                    'end_time' => $daySchedule['end_time'],
                    'appointment_duration' => $daySchedule['appointment_duration'],
                    'is_active' => $daySchedule['is_active'] ?? false,
                ]);
            } else {
                // Create a new schedule if no existing one for this day
                Schedule::create([
                    'doctor_id' => $doctor_id,
                    'day_of_week' => $day,
                    'start_time' => $daySchedule['start_time'],
                    'end_time' => $daySchedule['end_time'],
                    'appointment_duration' => $daySchedule['appointment_duration'],
                    'is_active' => $daySchedule['is_active'] ?? false,
                ]);
            }
        }

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Doctor $doctor, Schedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index', $doctor)->with('success', 'Schedule deleted successfully.');
    }
}
