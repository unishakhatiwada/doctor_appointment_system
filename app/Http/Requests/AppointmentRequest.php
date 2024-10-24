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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:patients,email',
            'phone' => 'required|string|max:15',
            'age' => 'required|integer|min:1',
            'gender' => 'required|string|in:male,female,other',
            'appointment_date' => 'required|date',  // The date should now come from the selected schedule
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor.',
            'schedule_id.required' => 'Please select a time slot.',
            'appointment_date.required' => 'Please select the appointment date.',
            'appointment_time.required' => 'Please select the appointment time.',
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.required' => 'Phone number is required.',
        ];
    }
}
