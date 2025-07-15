@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Crear Nueva Institución</h2>
                    <a href="{{ route('institutions.index') }}"
                       class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back to List
                    </a>
                </div>

                <form method="POST" action="{{ route('institutions.store') }}" class="space-y-6">
                    @csrf
                    @include('institutions.form')

                    <div class="flex items-center justify-end">
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Crear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
