<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Name Field -->
    <div class="md:col-span-2">
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre *</label>
        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $institution->name ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Type Field -->
    <div>
        <label for="type" class="block text-sm font-medium text-gray-700">Tipo *</label>
        <input type="text"
               name="type"
               id="type"
               value="{{ old('type', $institution->type ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('type') border-red-300 @enderror">
        @error('type')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Website Field -->
    <div>
        <label for="website" class="block text-sm font-medium text-gray-700">Sitio Web</label>
        <input type="url"
               name="website"
               id="website"
               value="{{ old('website', $institution->website ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('website') border-red-300 @enderror">
        @error('website')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email"
               name="email"
               id="email"
               value="{{ old('email', $institution->email ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Facebook URL Field -->
    <div>
        <label for="facebook_url" class="block text-sm font-medium text-gray-700">Facebook</label>
        <input type="url"
               name="facebook_url"
               id="facebook_url"
               value="{{ old('facebook_url', $institution->facebook_url ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('facebook_url') border-red-300 @enderror">
        @error('facebook_url')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Twitter URL Field -->
    <div>
        <label for="twitter_url" class="block text-sm font-medium text-gray-700">X / Twitter</label>
        <input type="url"
               name="twitter_url"
               id="twitter_url"
               value="{{ old('twitter_url', $institution->twitter_url ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('twitter_url') border-red-300 @enderror">
        @error('twitter_url')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Schedule Field -->
    <div>
        <label for="schedule" class="block text-sm font-medium text-gray-700">Horario de atención</label>
        <input type="text"
               name="schedule"
               id="schedule"
               value="{{ old('schedule', $institution->schedule ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('schedule') border-red-300 @enderror">
        @error('schedule')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Description Field -->
    <div class="md:col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
        <textarea name="description"
                  id="description"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('description') border-red-300 @enderror">{{ old('description', $institution->description ?? '') }}</textarea>
        @error('description')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Address Field -->
    <div class="md:col-span-2">
        <label for="address" class="block text-sm font-medium text-gray-700">Dirección</label>
        <textarea name="address"
                  id="address"
                  rows="3"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 wysiwyg-editor @error('address') border-red-300 @enderror">{{ old('address', $institution->address ?? '') }}</textarea>
        @error('address')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>
