<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:doctors,email',
            'phone' => 'required|string|unique:doctors,phone',
            'address' => 'required|string',
            'status' => 'required|in:active,inactive',
            'date_of_birth_ad' => 'nullable|date',
            'date_of_birth_bs' => 'nullable|string',
        ];
    }
}
