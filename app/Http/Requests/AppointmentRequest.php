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
            'phone' => [
                'required',
                'regex:/^(98|97)[0-9]{8}$|^\+?[1-9]\d{0,2}[\s\-\(\)]*\d{3}[\s\-\(\)]*\d{3,4}[\s\-\(\)]*\d{4}$/'
            ],
            'age' => 'required|integer|min:1|max:105',
            'gender' => 'required|string|in:male,female,other',
            'appointment_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'Please select a doctor.',
            'schedule_id.required' => 'Please select a time slot.',
            'appointment_date.required' => 'Please select the appointment date.',
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.required' => 'Phone number is required.',
            'phone.regex' => 'Please enter a valid phone number. Nepali numbers must start with 98 or 97 and have 10 digits. International numbers must start with a country code.',
        ];
    }
}
