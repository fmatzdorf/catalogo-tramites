<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Heroicons -->
        <script src="https://unpkg.com/heroicons@2.0.16/24/outline/index.js" type="module"></script>
        <script src="https://unpkg.com/heroicons@2.0.16/24/solid/index.js" type="module"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="min-h-screen">
            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <div class="bg-white shadow-sm border-b border-gray-200">
                    <div class="px-4 py-2 flex items-center justify-between">
                        <h1 class="text-xl font-semibold text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
                        <button type="button" class="mobile-menu-button p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <span class="sr-only">Abrir menú</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile sidebar -->
            <div class="mobile-menu lg:hidden hidden">
                <div class="fixed inset-0 flex z-40">
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
                    <div class="relative flex-1 flex flex-col max-w-xs w-full bg-white">
                        <div class="absolute top-0 right-0 -mr-12 pt-2">
                            <button type="button" class="mobile-menu-close ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                                <span class="sr-only">Cerrar</span>
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex-1 h-0 pt-5 pb-4 overflow-y-auto">
                            <div class="flex-shrink-0 flex items-center px-4">
                                <h1 class="text-xl font-semibold text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
                            </div>
                            <nav class="mt-8 flex-1 px-2 space-y-1">
                                @include('layouts.navigation-menu')
                            </nav>
                        </div>

                        <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                            <div class="flex-shrink-0 w-full group block">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                            <span class="text-sm font-medium text-white">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'user' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex">
                <!-- Desktop sidebar -->
                <div class="hidden lg:flex lg:flex-shrink-0">
                    <div class="flex flex-col w-64">
                        <div class="flex flex-col h-0 flex-1 bg-white border-r border-gray-200">
                            <!-- Sidebar header -->
                            <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto">
                                <div class="flex items-center flex-shrink-0 px-4">
                                    <h1 class="text-xl font-semibold text-gray-900">{{ config('app.name', 'Laravel') }}</h1>
                                </div>

                                <!-- Navigation -->
                                <nav class="mt-8 flex-1 px-2 space-y-1">
                                    @include('layouts.navigation-menu')
                                </nav>
                            </div>

                            <!-- User info -->
                            <div class="flex-shrink-0 flex border-t border-gray-200 p-4">
                                <div class="flex-shrink-0 w-full group block">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                                <span class="text-sm font-medium text-white">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</p>
                                            <p class="text-xs text-gray-500 capitalize">{{ Auth::user()->role ?? 'user' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
                <div class="flex-1">
                    <div class="flex-1">
                        <!-- Page header -->
                        <div class="bg-white shadow-sm">
                            <div class="px-4 sm:px-6 lg:px-8">
                                <div class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h1 class="text-2xl font-semibold text-gray-900">
                                                @yield('page-title', 'Dashboard')
                                            </h1>
                                            @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
                                                <nav class="flex mt-2" aria-label="Breadcrumb">
                                                    <ol class="flex items-center space-x-4">
                                                        @foreach($breadcrumbs as $breadcrumb)
                                                            <li>
                                                                <div class="flex items-center">
                                                                    @if(!$loop->first)
                                                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                                        </svg>
                                                                    @endif
                                                                    @if(isset($breadcrumb['url']))
                                                                        <a href="{{ $breadcrumb['url'] }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                                                            {{ $breadcrumb['name'] }}
                                                                        </a>
                                                                    @else
                                                                        <span class="ml-4 text-sm font-medium text-gray-900">
                                                                            {{ $breadcrumb['name'] }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </nav>
                                            @endif
                                        </div>

                                        <!-- User menu -->
                                        <div class="relative">
                                            <div class="flex items-center space-x-4">
                                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium">
                                                        Salir
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Flash messages -->
                        @if(session('success'))
                            <div class="bg-green-50 border border-green-200 rounded-md p-4 mx-4 mt-4 sm:mx-6 lg:mx-8">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-50 border border-red-200 rounded-md p-4 mx-4 mt-4 sm:mx-6 lg:mx-8">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Page content -->
                        <main class="px-4 py-6 sm:px-6 lg:px-8">
                            @yield('content')
                        </main>
                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScript for mobile menu -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');
                const mobileMenuClose = document.querySelector('.mobile-menu-close');
                const overlay = document.querySelector('.mobile-menu .fixed.inset-0.bg-gray-600');

                function toggleMobileMenu() {
                    mobileMenu.classList.toggle('hidden');
                }

                mobileMenuButton?.addEventListener('click', toggleMobileMenu);
                mobileMenuClose?.addEventListener('click', toggleMobileMenu);
                overlay?.addEventListener('click', toggleMobileMenu);
            });
        </script>
    </body>
</html>
