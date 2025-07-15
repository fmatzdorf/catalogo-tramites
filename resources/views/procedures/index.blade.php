@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Trámites</h2>
                    @can('create', App\Models\Procedure::class)
                        <a href="{{ route('procedures.create') }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Nuevo Trámite
                        </a>
                    @endcan
                </div>

                <!-- Filters -->
                <div class="mb-6 bg-gray-50 p-4 rounded-lg">
                    <form method="GET" action="{{ route('procedures.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Buscar trámites..."
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </div>
                        <div>
                            <select name="category_id"
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="">Todas las categorías</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
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
                            <a href="{{ route('procedures.index') }}"
                               class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Procedures Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Título
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Categoría
                                </th>
                                @if(auth()->user()->role === 'admin')
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Institución
                                    </th>
                                @endif
                                @if(auth()->user()->role === 'admin')
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
                            @forelse($procedures as $procedure)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $procedure->title }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $procedure->category->name ?? 'Sin categoría' }}
                                        </div>
                                    </td>
                                    @if(auth()->user()->role === 'admin')
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $procedure->institution->name ?? 'Sin institución' }}
                                            </div>
                                        </td>
                                    @endif
                                    @if(auth()->user()->role === 'admin')
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{ $institution->created_at->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                by {{ $institution->createdBy->name ?? 'System' }}
                                            </div>
                                        </td>
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @can('update', $procedure)
                                                <a href="{{ route('procedures.edit', $procedure) }}"
                                                   class="text-indigo-600 hover:text-indigo-900"
                                                   title="Edit">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                            @endcan
                                            @can('delete', $procedure)
                                                <form action="{{ route('procedures.destroy', $procedure) }}"
                                                      method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('¿Está seguro que desea eliminar este trámite?');">
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
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'admin' ? '6' : '5' }}" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                        No hay trámites.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>



                <!-- Pagination -->
                @if($procedures->hasPages())
                    <div class="mt-4">
                        {{ $procedures->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
