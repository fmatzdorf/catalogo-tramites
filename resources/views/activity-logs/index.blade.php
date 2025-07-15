@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Filters -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros</h3>
                <form method="GET" action="{{ route('activity-logs.index') }}" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700">Usuario</label>
                        <select name="user_id" id="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Todos los Usuarios</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="item_type" class="block text-sm font-medium text-gray-700">Entidad</label>
                        <select name="item_type" id="item_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Todas</option>
                            @foreach($itemTypes as $type)
                                <option value="{{ $type }}" {{ request('item_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="action" class="block text-sm font-medium text-gray-700">Acción</label>
                        <select name="action" id="action" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">Todas</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700">Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700">Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>

                    <div class="md:col-span-3 lg:col-span-5 flex justify-start space-x-2">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Aplicar
                        </button>
                        <a href="{{ route('activity-logs.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Activity Logs Table -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Registro de Actividades</h3>
                    <p class="text-sm text-gray-600">
                        Mostrando {{ $logs->firstItem() ?? 0 }} a {{ $logs->lastItem() ?? 0 }} de {{ $logs->total() }} resultados
                    </p>
                </div>

                @if($logs->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha y Hora
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Usuario
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acción
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Entidad
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($logs as $log)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at->format('Y-m-d H:i:s') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->user ? $log->user->name : 'Unknown User' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($log->action === 'create') bg-green-100 text-green-800
                                                @elseif($log->action === 'update') bg-blue-100 text-blue-800
                                                @elseif($log->action === 'delete') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ ucfirst($log->item_type) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->item_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('activity-logs.show', $log) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay registro de actividades.</h3>
                        <p class="mt-1 text-sm text-gray-500">Ningún registro corresponde a los filtros aplicados.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
