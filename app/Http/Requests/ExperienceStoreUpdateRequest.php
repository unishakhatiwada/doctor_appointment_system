<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'job_title' => 'required|string',
            'type_of_employment' => 'required|string',
            'health_care_name' => 'required|string',
            'health_care_location' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'additional_detail' => 'nullable|string',
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
