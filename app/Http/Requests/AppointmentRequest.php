<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_id' => 'required|exists:schedules,id',
            'appointment_date' => 'required|date|after:today',  // Date must be in the future
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor.',
            'schedule_id.required' => 'Please select a time slot.',
            'appointment_date.after' => 'Appointment date must be in the future.',
        ];
    }
}
