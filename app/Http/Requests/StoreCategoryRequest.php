<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Category::class);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'parent_category_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) {
                    if ($value && $this->wouldCreateCircularReference($value)) {
                        $fail('The selected parent category would create a circular reference.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.unique' => 'A category with this name already exists.',
            'parent_category_id.exists' => 'The selected parent category does not exist.',
        ];
    }

    private function wouldCreateCircularReference($parentId): bool
    {
        // For new categories, we don't need to check circular references
        return false;
    }
}
