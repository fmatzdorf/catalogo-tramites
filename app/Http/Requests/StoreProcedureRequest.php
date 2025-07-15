<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcedureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Procedure::class);
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'normative' => 'nullable|string',
            'instructions' => 'nullable|string',
            'requirements' => 'nullable|string',
            'cost' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'response_time' => 'nullable|string|max:255',
            'result_type' => 'nullable|string|max:255',
            'url' => 'nullable|url|max:255',
        ];

        // Admin users can select any institution, institutional users are restricted to their own
        if ($this->user()->role === 'admin') {
            $rules['institution_id'] = 'required|exists:institutions,id';
        } else {
            $rules['institution_id'] = 'required|exists:institutions,id|in:' . $this->user()->institution_id;
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The procedure title is required.',
            'category_id.required' => 'Please select a category.',
            'category_id.exists' => 'The selected category does not exist.',
            'institution_id.required' => 'Please select an institution.',
            'institution_id.exists' => 'The selected institution does not exist.',
            'institution_id.in' => 'You can only create procedures for your own institution.',
        ];
    }
}
