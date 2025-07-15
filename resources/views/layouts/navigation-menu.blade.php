@php
    $userRole = Auth::user()->role ?? 'user';
    $isAdmin = $userRole === 'admin';
    $isInstitutional = $userRole === 'institutional';
@endphp

<!-- Dashboard -->
<a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v4H8V5z" />
    </svg>
    Principal
</a>

<!-- Procedures -->
<a href="{{ route('procedures.index') }}" class="nav-link {{ request()->routeIs('procedures.*') ? 'active' : '' }}">
    <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
    </svg>
    Trámites
</a>

<!-- Institutions (Admin only or own institution for institutional users) -->
@if($isAdmin)
    <a href="{{ route('institutions.index') }}" class="nav-link {{ request()->routeIs('institutions.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2m6 0a2 2 0 002-2v-2m0 0V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v8a2 2 0 002 2h2z" />
        </svg>
        Instituciones
    </a>
@elseif($isInstitutional && Auth::user()->institution_id)
    <a href="{{ route('institutions.edit', Auth::user()->institution_id) }}" class="nav-link {{ request()->routeIs('institutions.edit') && request()->route('institution') == Auth::user()->institution_id ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2m6 0a2 2 0 002-2v-2m0 0V7a2 2 0 00-2-2H9a2 2 0 00-2 2v2m0 0v8a2 2 0 002 2h2z" />
        </svg>
        Mi Institución
    </a>
@endif

<!-- Categories (Admin only) -->
@if($isAdmin)
    <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
        </svg>
        Categorías
    </a>
@endif

<!-- Users -->
@if($isAdmin)
    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5zm.5 3.5h-6v-1a5 5 0 0110 0v1z" />
        </svg>
        Usuarios
    </a>
@elseif($isInstitutional)
    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5zm.5 3.5h-6v-1a5 5 0 0110 0v1z" />
        </svg>
        Usuarios Institucionales
    </a>
@endif

<!-- Activity Logs (Admin only) -->
@if($isAdmin)
    <div class="mt-8">
        <h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">
            Sistema
        </h3>
        <div class="mt-2 space-y-1">
            <a href="{{ route('activity-logs.index') }}" class="nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Registro de Acciones
            </a>
        </div>
    </div>
@endif

<style>
    .nav-link {
        @apply flex items-center px-2 py-2 text-sm font-medium rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-50 group;
    }

    .nav-link.active {
        @apply bg-indigo-50 text-indigo-700 hover:bg-indigo-50;
    }

    .nav-icon {
        @apply mr-3 flex-shrink-0 h-5 w-5;
    }

    .nav-link.active .nav-icon {
        @apply text-indigo-500;
    }
</style>
