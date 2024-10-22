<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $schedules = $this->input('schedule', []);

        foreach ($schedules as $day => $schedule) {
            if (isset($schedule['start_time'])) {
                $schedules[$day]['start_time'] = $schedule['start_time'] . ':00'; // Append :00 for seconds
            }
            if (isset($schedule['end_time'])) {
                $schedules[$day]['end_time'] = $schedule['end_time'] . ':00'; // Append :00 for seconds
            }
        }

        // Replace the modified schedule input
        $this->merge(['schedule' => $schedules]);
    }

    public function rules(): array
    {
        $rules = [
            'doctor_id' => 'required|exists:doctors,id',
        ];

        foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            $rules["schedule.{$day}.start_time"] = [
                'required',
                'date_format:H:i:s', // Expect H:i:s format after appending seconds
                function ($attribute, $value, $fail) use ($day) {
                    $startTime = $value;
                    $endTime = $this->input("schedule.{$day}.end_time");

                    // Ensure end_time is greater than start_time
                    if ($endTime && $startTime >= $endTime) {
                        $fail("The end time for {$day} must be after the start time.");
                    }
                },
            ];
            $rules["schedule.{$day}.end_time"] = 'required|date_format:H:i:s'; // Expect H:i:s format after appending seconds
            $rules["schedule.{$day}.appointment_duration"] = 'required|integer|min:5|max:120';
            $rules["schedule.{$day}.is_active"] = 'nullable|boolean';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'schedule.*.start_time.required' => 'Start time is required for each day.',
            'schedule.*.end_time.required' => 'End time is required for each day.',
            'schedule.*.start_time.date_format' => 'Start time must be in the correct format (H:i:s).',
            'schedule.*.end_time.date_format' => 'End time must be in the correct format (H:i:s).',
            'schedule.*.appointment_duration.required' => 'Appointment duration is required for each day.',
            'schedule.*.appointment_duration.integer' => 'Appointment duration must be a valid number (minutes).',
            'schedule.*.appointment_duration.min' => 'Minimum appointment duration is 5 minutes.',
            'schedule.*.appointment_duration.max' => 'Maximum appointment duration is 120 minutes.',
            'schedule.*.is_active.boolean' => 'The active status must be true or false.',
        ];
    }
}
