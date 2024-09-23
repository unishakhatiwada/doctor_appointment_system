<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationStoreUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'degree' => 'required|string',
            'university' => 'required|string',
            'institute' => 'required|string',
            'field_of_study' => 'required|string',
            'join_date' => 'required|date',
            'graduation_date' => 'required|date|after_or_equal:join_date',
            'grade' => 'nullable|string',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'additional_details' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'doctor_id.required' => 'The doctor field is required.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
        ];
    }
}
