@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Usuarios</h2>
                    @can('create', App\Models\User::class)
                        <a href="{{ route('users.create') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Crear Usuario
                        </a>
                    @endcan
                </div>

                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Buscar usuarios..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <select name="role"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Todos los roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="institutional" {{ request('role') === 'institutional' ? 'selected' : '' }}>Institucional</option>
                            </select>
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <div>
                                <select name="institution_id"
                                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <option value="">Todas las instituciones</option>
                                    @foreach($institutions as $institution)
                                        <option value="{{ $institution->id }}"
                                                {{ request('institution_id') == $institution->id ? 'selected' : '' }}>
                                            {{ $institution->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div class="flex gap-2">
                            <button type="submit"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filtrar
                            </button>
                            <a href="{{ route('users.index') }}"
                               class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Users Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rol
                                </th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Institución
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Creado
                                    </th>
                                @endif
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ substr($user->name, 0, 2) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $user->name }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $user->email }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $user->institution->name ?? '---' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                {{ $user->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                by {{ $user->createdBy->name ?? 'System' }}
                                            </div>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @can('update', $user)
                                                <a href="{{ route('users.edit', $user) }}"
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete', $user)
                                                @if($user->id !== auth()->id())
                                                    <form action="{{ route('users.destroy', $user) }}"
                                                          method="POST"
                                                          class="inline-block"
                                                          onsubmit="return confirm('¿Está seguro que desea eliminar este usuario?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-900"
                                                                title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '6' : '4' }}" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No hay usuarios.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
