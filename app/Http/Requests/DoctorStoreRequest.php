<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'regex:/^(?:(?:\+977|977|0)?9\d{8}|(?:\+977|977|0)?1\d{7}|9\d{9})$/', // Nepali or International number format
                'unique:doctors,phone',
            ],
            'email' => 'required|string|email|unique:doctors,email',
            'password' => 'required|string|min:6|confirmed',
            'permanent_province_id' => 'required|exists:provinces,id',
            'permanent_district_id' => 'required|exists:districts,id',
            'permanent_municipality_id' => 'required|exists:municipalities,id',
            'temporary_province_id' => 'required|exists:provinces,id',
            'temporary_district_id' => 'required|exists:districts,id',
            'temporary_municipality_id' => 'required|exists:municipalities,id',
            'gender' => 'required|in:male,female,other',
            'marital_status' => 'required|in:single,married,divorced,widowed',
            'status' => 'required|in:active,inactive',
            'department_id' => 'required|exists:departments,id',
            'date_of_birth_bs' => 'required|string',
            'date_of_birth_ad' => 'required|date',

            // Nested validation for education
            'education.*.degree' => 'required|in:+2,bachelor,master,phd',
            'education.*.institute_name' => 'required|string',
            'education.*.institute_address' => 'required|string',
            'education.*.faculty' => 'required|string',
            'education.*.additional_detail' => 'nullable|string',
            'education.*.grade' => 'required|integer|min:0|max:4',
            'education.*.joining_date_bs' => 'nullable|string', // BS Date is optional but should be string format
            'education.*.joining_date_ad' => 'required|date', // AD Date is required
            'education.*.graduation_date_bs' => 'nullable|string', // Optional BS date
            'education.*.graduation_date_ad' => 'nullable|date|after_or_equal:education.*.joining_date_ad', // AD Graduation date must be after joining date
            'education.*.certificate' => 'nullable|file|mimes:pdf|max:2048', // Multiple files allowed, max size 2MB

            // Nested validation for experience
            'experience.*.job_title' => 'required|string',
            'experience.*.type_of_employment' => 'required|string',
            'experience.*.health_care_name' => 'required|string',
            'experience.*.health_care_location' => 'required|string',
            'experience.*.additional_detail' => 'nullable|string',
            'experience.*.start_date_bs' => 'nullable|string', // BS Start Date (optional)
            'experience.*.start_date_ad' => 'required|date', // AD Start Date (required)
            'experience.*.end_date_bs' => 'nullable|string', // BS End Date (optional)
            'experience.*.end_date_ad' => 'nullable|date|after_or_equal:experience.*.start_date_ad', // AD End date must be after the start date
            'experience.*.certificate' => 'nullable|file|mimes:pdf|max:2048', // Multiple files allowed, max size 2MB
        ];

    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
            'phone.unique' => 'The phone number has already been taken. Please choose a different one.',
            'phone.regex' => 'The phone number must be a valid Nepali or international phone number format.',
            'department_id.exists' => 'The selected department is invalid.',
            'education.*.graduation_date.after_or_equal' => 'The graduation date must be after or equal to the joining date.',
            'experience.*.end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }
}
