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
            'experience.*.job_title' => 'required|string|max:255',
            'experience.*.type_of_employment' => 'required|in:full_time,part_time,contract,internship',
            'experience.*.health_care_name' => 'required|string|max:255',
            'experience.*.health_care_location' => 'required|string|max:255',
            'experience.*.start_date' => 'required|date|before_or_equal:today',
            'experience.*.end_date' => 'nullable|date|after_or_equal:experience.*.start_date',
            'experience.*.additional_detail' => 'nullable|string|max:500',
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
