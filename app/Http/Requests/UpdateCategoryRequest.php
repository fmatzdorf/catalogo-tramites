<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('category'));
    }

    public function rules(): array
    {
        $category = $this->route('category');

        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'parent_category_id' => [
                'nullable',
                'exists:categories,id',
                'not_in:' . $category->id,
                function ($attribute, $value, $fail) use ($category) {
                    if ($value && $this->wouldCreateCircularReference($category, $value)) {
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
            'parent_category_id.not_in' => 'A category cannot be its own parent.',
        ];
    }

    private function wouldCreateCircularReference(Category $category, $parentId): bool
    {
        $parent = Category::find($parentId);
        if (!$parent) {
            return false;
        }

        // Check if the parent or any of its ancestors is the current category
        $ancestors = $parent->ancestors()->pluck('id')->toArray();
        return in_array($category->id, $ancestors);
    }
}
