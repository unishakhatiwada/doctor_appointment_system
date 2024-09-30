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
            'education.*.doctor_id' => 'required|exists:doctors,id',
            'education.*.degree' => 'required|string|in:+2,bachelor,master,phd',
            'education.*.institute_name' => 'required|string|max:255',
            'education.*.institute_address' => 'required|string|max:255',
            'education.*.faculty' => 'required|string|max:255',
            'education.*.joining_date' => 'required|date|before_or_equal:today',
            'education.*.graduation_date' => 'required|date|after_or_equal:education.*.start_date',
            'education.*.additional_detail' => 'nullable|string|max:500',
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
