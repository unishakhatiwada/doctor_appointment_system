<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorUpdateRequest extends FormRequest
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
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('doctors', 'email')->ignore($this->doctor->id), // Ignore the current doctor's email
            ],
            'phone' => [
                'required',
                'string',
                'regex:/^(?:(?:\+977|977|0)?9\d{8}|(?:\+977|977|0)?1\d{7}|9\d{9})$/', // Nepali number format
                'regex:/^(?:\+?\d{1,3}[- ]?)?\d{10}$/', // International format
                Rule::unique('doctors', 'phone')->ignore($this->doctor->id), // Ignore the current doctor's phone
            ],
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
            'date_of_birth_ad' => 'nullable|date',
            'date_of_birth_bs' => 'nullable|string',
        ];
    }


    public function messages(): array
    {
        return [
            'email.unique' => 'The email has already been taken. Please choose a different one.',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number format is invalid.',
            'phone.unique' => 'This phone number has already been taken.',
        ];
    }
}
