<div class="space-y-6">
    <!-- Title Field -->
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
        <input type="text"
               name="title"
               id="title"
               value="{{ old('title', $procedure->title ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-red-300 @enderror">
        @error('title')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Category Field -->
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Categoría *</label>
            <select name="category_id"
                    id="category_id"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-red-300 @enderror">
                <option value="">-- Categoría --</option>
                @foreach($categories as $category)
                    @if($category->parent_category_id)
                        <option value="{{ $category->id }}"
                                {{ old('category_id', $procedure->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->getFullPath() }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Institution Field -->
        <div>
            <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución *</label>
            @if(Auth::user()->role === 'admin')
                <select name="institution_id"
                        id="institution_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('institution_id') border-red-300 @enderror">
                    <option value="">-- Institución --</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}"
                                {{ old('institution_id', $procedure->institution_id ?? '') == $institution->id ? 'selected' : '' }}>
                            {{ $institution->name }}
                        </option>
                    @endforeach
                </select>
            @else
                <input type="hidden" name="institution_id" value="{{ Auth::user()->institution_id }}">
                <input type="text"
                       value="{{ Auth::user()->institution->name }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
                       readonly>
                <p class="mt-1 text-sm text-gray-500">No tiene permisos para cambiar la institución.</p>
            @endif
            @error('institution_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Description Field -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="description"
                  id="description"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('description') border-red-300 @enderror">{{ old('description', $procedure->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Normative Field -->
    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Normativa</label>
        <textarea name="normative"
                  id="normative"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('normative') border-red-300 @enderror">{{ old('normative', $procedure->normative ?? '') }}</textarea>
        @error('normative')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Instructions Field -->
    <div>
        <label for="instructions" class="block text-sm font-medium text-gray-700">Instrucciones</label>
        <textarea name="instructions"
                  id="instructions"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('instructions') border-red-300 @enderror">{{ old('instructions', $procedure->instructions ?? '') }}</textarea>
        @error('instructions')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Requirements Field -->
    <div>
        <label for="requirements" class="block text-sm font-medium text-gray-700">Requerimientos</label>
        <textarea name="requirements"
                  id="requirements"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('requirements') border-red-300 @enderror">{{ old('requirements', $procedure->requirements ?? '') }}</textarea>
        @error('requirements')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Cost Field -->
    <div>
        <label for="requirements" class="block text-sm font-medium text-gray-700">Costo</label>
        <textarea name="cost"
                  id="cost"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('cost') border-red-300 @enderror">{{ old('cost', $procedure->cost ?? '') }}</textarea>
        @error('cost')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6">
        <!-- Currency Field -->
        <div>
            <label for="currency" class="block text-sm font-medium text-gray-700">Moneda (código)</label>
            <input type="text"
                   name="currency"
                   id="currency"
                   value="{{ old('currency', $procedure->currency ?? '') }}"
                   placeholder="ej. GTQ, USD"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('currency') border-red-300 @enderror">
            @error('currency')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Response Time Field -->
        <div>
            <label for="response_time" class="block text-sm font-medium text-gray-700">Tiempo de Respuesta</label>
            <input type="text"
                   name="response_time"
                   id="response_time"
                   value="{{ old('response_time', $procedure->response_time ?? '') }}"
                   placeholder="ej. 20 días hábiles"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('response_time') border-red-300 @enderror">
            @error('response_time')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Result Type Field -->
        <div>
            <label for="result_type" class="block text-sm font-medium text-gray-700">Tipo de Resultado</label>
            <input type="text"
                   name="result_type"
                   id="result_type"
                   value="{{ old('result_type', $procedure->result_type ?? '') }}"
                   placeholder="ej. Certificado, Licencia"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('result_type') border-red-300 @enderror">
            @error('result_type')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- URL Field -->
        <div>
            <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
            <input type="text"
                   name="url"
                   id="url"
                   value="{{ old('url', $procedure->url ?? '') }}"
                   placeholder="https://"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('url') border-red-300 @enderror">
            @error('url')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
