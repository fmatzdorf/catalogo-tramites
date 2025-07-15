@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Información Básica</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha y Hora</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $activityLog->created_at->format('Y-m-d H:i:s') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Usuario</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $activityLog->user ? $activityLog->user->name : 'Usuario desconocido' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Acción</label>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($activityLog->action === 'create') bg-green-100 text-green-800
                                    @elseif($activityLog->action === 'update') bg-blue-100 text-blue-800
                                    @elseif($activityLog->action === 'delete') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($activityLog->action) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Entidad</label>
                            <p class="mt-1 text-sm text-gray-900">{{ ucfirst($activityLog->item_type) }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">ID</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $activityLog->item_id }}</p>
                        </div>
                    </div>

                    <!-- Item Data -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Data</h3>

                        @if($activityLog->item_data)
                            @if($activityLog->item_data)
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <div class="space-y-2">
                                        @foreach($activityLog->item_data as $key => $value)
                                            <div class="flex">
                                                <span class="font-medium text-gray-700 w-1/3">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                <span class="text-gray-900 w-2/3 break-words">
                                                    @if(is_array($value) || is_object($value))
                                                        {{ json_encode($value) }}
                                                    @elseif(is_bool($value))
                                                        {{ $value ? 'true' : 'false' }}
                                                    @elseif(is_null($value))
                                                        <span class="text-gray-500 italic">null</span>
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">JSON no válido</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-500 italic">No hay datos disponibles</p>
                        @endif
                    </div>
                </div>

                <!-- Raw JSON Data (collapsible) -->
                @if($activityLog->item_data)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <details class="group">
                            <summary class="flex cursor-pointer items-center justify-between py-2 font-medium text-gray-900 hover:text-gray-700">
                                <span>JSON</span>
                                <svg class="ml-1.5 h-5 w-5 flex-shrink-0 transform transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </summary>
                            <div class="mt-2">
                                <pre class="bg-gray-900 text-green-400 p-4 rounded-lg text-sm overflow-x-auto">{{ json_encode($activityLog->item_data, JSON_PRETTY_PRINT) }}</pre>
                            </div>
                        </details>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
