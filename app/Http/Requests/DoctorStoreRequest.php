<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'phone.unique' => 'The phone number has already been taken. Please choose a different one.',
            'phone.regex' => 'The phone number must be a valid Nepali phone number format.',

        ];
    }

}
