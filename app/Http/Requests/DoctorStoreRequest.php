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
            'name' => 'required|string',
            'phone' => [
                'required',
                'string',
                'regex:/^(?:(?:\+977|977|0)?9\d{8}|(?:\+977|977|0)?1\d{7}|9\d{9})$/', // Nepali number format
                'regex:/^(?:\+?\d{1,3}[- ]?)?\d{10}$/', // International format with optional country code
                'unique:doctors,phone',
            ],
            'email' => 'required|string|email|unique:doctors,email',
            'password' => 'required|string|min:6|confirmed',
            'province_id' => 'required|exists:provinces,id',
            'district_id' => 'required|exists:districts,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'status' => 'required|in:active,inactive',
            'department_id' => 'required|exists:departments,id',
            'dob_ad' => 'nullable|date',
            'dob_bs' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
            'phone.unique' => 'The phone number has already been taken. Please choose a different one.',
            'phone.regex' => 'The phone number must be a valid Nepali or international phone number format.',
            'department_id.exists' => 'The selected department is invalid.',
        ];
    }
}
