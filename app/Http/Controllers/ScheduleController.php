<?php

namespace App\Http\Controllers;

use App\DataTables\SchedulesDataTable;
use App\Http\Requests\ScheduleRequest;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\RedirectResponse;
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
        $doctorsWithoutSchedule = Doctor::doesntHave('schedules')->get();

        return view('schedules.create_edit', compact('doctorsWithoutSchedule'));
    }

    public function store(ScheduleRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $doctorId = $validated['doctor_id'];

        $schedules = [];

        foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            if (! empty($validated['schedule'][$day]['start_time']) && ! empty($validated['schedule'][$day]['end_time'])) {
                $schedules[] = [
                    'doctor_id' => $doctorId,
                    'day_of_week' => $day,
                    'start_time' => $validated['schedule'][$day]['start_time'],
                    'end_time' => $validated['schedule'][$day]['end_time'],
                    'appointment_duration' => $validated['schedule'][$day]['appointment_duration'],
                    'is_active' => $validated['schedule'][$day]['is_active'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Use transaction to ensure atomicity
        DB::transaction(function () use ($schedules) {
            // Bulk insert schedules in one query
            Schedule::insert($schedules);
        });

        return redirect()->route('schedules.index')->with('success', 'Doctor schedule created successfully for the entire week.');
    }

    public function edit(Schedule $schedule): View
    {
        // Load all schedules for the doctor, grouped by the day of the week
        $schedules = Schedule::where('doctor_id', $schedule->doctor_id)->get()->keyBy('day_of_week');

        // Pass the doctor and the schedules to the view
        return view('schedules.create_edit', [
            'doctor' => $schedule->doctor,
            'schedules' => $schedules,
            'schedule' => $schedule, // Pass the current schedule for edit mode
        ]);
    }

    public function update(ScheduleRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $doctor_id = $validated['doctor_id'];
        // Fetch all existing schedules for this doctor
        $existingSchedules = Schedule::where('doctor_id', $doctor_id)->get()->keyBy('day_of_week');

        DB::transaction(function () use ($validated, $doctor_id, $existingSchedules) {
            foreach ($validated['schedule'] as $day => $daySchedule) {
                // Check if a schedule exists for this day
                if (isset($existingSchedules[$day])) {
                    // Update the existing schedule
                    $existingSchedules[$day]->update([
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
        });

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Doctor $doctor, Schedule $schedule): RedirectResponse
    {
        $schedule->delete();

        return redirect()->route('schedules.index', $doctor)->with('success', 'Schedule deleted successfully.');
    }
}
