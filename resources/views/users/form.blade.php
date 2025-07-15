<div class="space-y-6">
    <!-- Name Field -->
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Nombre *</label>
        <input type="text"
               name="name"
               id="name"
               value="{{ old('name', $user->name ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('name') border-red-300 @enderror">
        @error('name')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Email Field -->
    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
        <input type="email"
               name="email"
               id="email"
               value="{{ old('email', $user->email ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-300 @enderror">
        @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Field -->
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">
            Contraseña {{ isset($user) ? '(Dejar en blanco para mantener la actual)' : '*' }}
        </label>
        <input type="password"
               name="password"
               id="password"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-300 @enderror">
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password Confirmation Field -->
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
            Confirmar Contraseña {{ isset($user) ? '(Requerido para cambiar contraseña)' : '*' }}
        </label>
        <input type="password"
               name="password_confirmation"
               id="password_confirmation"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Role Field -->
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700">Rol *</label>
            @if(Auth::user()->role === 'admin')
                <select name="role"
                        id="role"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('role') border-red-300 @enderror"
                        onchange="toggleInstitutionField()">
                    <option value="">-- Seleccionar Rol --</option>
                    <option value="admin" {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>
                        Administrador
                    </option>
                    <option value="institutional" {{ old('role', $user->role ?? '') == 'institutional' ? 'selected' : '' }}>
                        Institucional
                    </option>
                </select>
            @else
                <input type="hidden" name="role" value="institutional">
                <input type="text"
                       value="Institucional"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100"
                       readonly>
                <p class="mt-1 text-sm text-gray-500">El rol no puede ser cambiado con su rol actual.</p>
            @endif
            @error('role')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Institution Field -->
        <div id="institution-field" style="display: {{ old('role', $user->role ?? '') == 'institutional' ? 'block' : 'none' }};">
            <label for="institution_id" class="block text-sm font-medium text-gray-700">Institución *</label>
            @if(Auth::user()->role === 'admin')
                <select name="institution_id"
                        id="institution_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('institution_id') border-red-300 @enderror">
                    <option value="">-- Seleccionar Institución --</option>
                    @foreach($institutions as $institution)
                        <option value="{{ $institution->id }}"
                                {{ old('institution_id', $user->institution_id ?? '') == $institution->id ? 'selected' : '' }}>
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
                <p class="mt-1 text-sm text-gray-500">La institución no puede ser cambiada con su rol actual.</p>
            @endif
            @error('institution_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<script>
function toggleInstitutionField() {
    const roleSelect = document.getElementById('role');
    const institutionField = document.getElementById('institution-field');

    if (roleSelect.value === 'institutional') {
        institutionField.style.display = 'block';
    } else {
        institutionField.style.display = 'none';
    }
}
</script>
