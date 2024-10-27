<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
    dd($this    );
         $rules = [
        'title' => 'required|string|max:255',
        'display' => 'required|string|in:visible,hidden',
        'status' => 'required|boolean',
        'parent_id' => 'nullable|exists:menu_items,id',
        'type' => 'required|in:module,page,external_link',
        'order' => 'integer',
    ];

        // Conditionally require type_id for module and page types
        if ($this->input('type') === 'module' || $this->input('type') === 'page') {
            $rules['type_id'] = 'required|integer|exists:'.($this->input('type') === 'module' ? 'modules' : 'pages').',id';
        } else {
            // Make sure type_id is nullable for other types
            $rules['type_id'] = 'nullable';
        }

        if ($this->input('type') === 'external_link') {
            $rules['external_link'] = 'required|url';
        } else {
            $rules['external_link'] = 'nullable';
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'display.required' => 'The display setting is required.',
            'status.required' => 'The status field is required.',
            'parent_id.exists' => 'The selected parent menu does not exist.',
            'type.required' => 'The type of menu item is required.',
            'type.in' => 'The type must be one of: module, page, or external link.',
            'type_id.required' => 'A type ID is required for module and page types.',
            'external_link.required' => 'An external link URL is required for external link type.',
            'external_link.url' => 'The external link must be a valid URL.',
        ];
    }
}
