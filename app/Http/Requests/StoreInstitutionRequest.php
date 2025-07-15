<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitutionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Institution::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:institutions,name',
            'type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'schedule' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The institution name is required.',
            'name.unique' => 'An institution with this name already exists.',
            'type.required' => 'The institution type is required.',
            'website.url' => 'Please enter a valid website URL.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
