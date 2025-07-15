<div class="space-y-6">
    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre *</label>
        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $category->name ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Parent Category Field -->
    <div>
        <label for="parent_category_id" class="block text-sm font-medium text-gray-700">Categoría Madre</label>
        <select name="parent_category_id"
                id="parent_category_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('parent_category_id') border-red-300 @enderror">
            <option value="">-- (Categoría Raíz) --</option>
            @foreach($parentCategories as $parentCategory)
                <option value="{{ $parentCategory->id }}"
                        {{ old('parent_category_id', $category->parent_category_id ?? '') == $parentCategory->id ? 'selected' : '' }}>
                    {{ $parentCategory->name }}
                </option>
            @endforeach
        </select>
        @error('parent_category_id')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description Field -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="description"
                  id="description"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('description') border-red-300 @enderror">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
