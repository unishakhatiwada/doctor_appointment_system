<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'doctor_id' => 'required|exists:doctors,id',
        ];

        // Validation for each day of the week
        foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day) {
            // Validate time in 24-hour format (H:i) because input type="time" uses this format
            $rules["schedule.{$day}.start_time"] = 'required|date_format:H:i';
            $rules["schedule.{$day}.end_time"] = 'required|date_format:H:i';
            $rules["schedule.{$day}.appointment_duration"] = 'required|integer|min:5|max:120';
            $rules["schedule.{$day}.is_active"] = 'nullable|boolean';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            // Doctor validation messages
            'doctor_id.required' => 'The doctor selection is required.',
            'doctor_id.exists' => 'The selected doctor is invalid.',

            // Time validation messages for each day
            'schedule.*.start_time.required' => 'Start time is required for each day.',
            'schedule.*.end_time.required' => 'End time is required for each day.',
            'schedule.*.start_time.date_format' => 'Start time must be in the correct format (HH:MM).',
            'schedule.*.end_time.date_format' => 'End time must be in the correct format (HH:MM).',
            'schedule.*.appointment_duration.required' => 'Appointment duration is required for each day.',
            'schedule.*.appointment_duration.integer' => 'Appointment duration must be a valid number (minutes).',
            'schedule.*.appointment_duration.min' => 'Minimum appointment duration is 5 minutes.',
            'schedule.*.appointment_duration.max' => 'Maximum appointment duration is 120 minutes.',
            'schedule.*.is_active.boolean' => 'The active status must be true or false.',
        ];
    }
}
