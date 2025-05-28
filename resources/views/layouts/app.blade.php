<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TuitionCentre') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=nunito:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-blue-50">
        <div class="min-h-screen flex flex-col">
            <!-- Top Navigation -->
            <nav class="bg-gradient-to-r from-indigo-800 via-indigo-700 to-indigo-800 text-white shadow-md border-b-4 border-indigo-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <div class="flex items-center">
                            <!-- Logo with enhanced styling -->
                            <div class="flex-shrink-0 flex items-center bg-white rounded-b-lg px-4 py-2 shadow-lg border-t-4 border-indigo-400">
                                <div class="relative">
                                    <img class="h-12 w-auto" src="{{ asset('logo.ico') }}">
                                    <div class="absolute -top-1 -right-1 h-3 w-3 bg-green-500 rounded-full animate-pulse"></div>
                                </div>
                                <span class="ml-3 text-xl font-bold text-indigo-800">Aimi An Najjah <span class="text-indigo-600">Tuition Centre</span></span>
                            </div>
                        </div>
                        
                        <!-- User Profile Dropdown with enhanced styling -->
                        <div class="flex items-center">
                            <div class="mr-4 hidden md:block">
                                <div class="text-right">
                                    <p class="text-xs text-indigo-200">Welcome</p>
                                    <p class="font-medium text-white">{{ Auth::user()->name }}</p>
                                </div>
                            </div>
                            <div class="relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium bg-indigo-600 hover:bg-indigo-500 px-3 py-2 rounded-lg shadow-md transition ease-in-out duration-150 border border-indigo-500">
                                            <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center mr-2">
                                                <span class="text-sm font-bold text-indigo-700">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                            </div>
                                            <div class="mr-1">{{ Auth::user()->name }}</div>
                                            <svg class="h-4 w-4 text-indigo-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                                this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>

                            <!-- Mobile menu button -->
                          
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Mobile Navigation Menu -->
          

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 flex items-center">
                        <div class="font-semibold text-xl text-gray-800">
                            {{ $header }}
                        </div>
                        @isset($actions)
                            <div class="ml-auto">
                                {{ $actions }}
                            </div>
                        @endisset
                    </div>
                </header>
            @endisset

            <!-- Main Content Area -->
            <div class="flex-grow">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                    <!-- Main Content Layout with Sidebar -->
                    <div class="grid grid-cols-12 gap-6">
                        <!-- Sidebar Component -->
                        <div class="col-span-12 md:col-span-3 lg:col-span-2">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                                <div class="p-4 bg-indigo-50 rounded-t-lg border-b border-indigo-100">
                                    <h3 class="font-medium text-indigo-800">Navigation</h3>
                                </div>
                                <nav class="py-2">
                                    <x-sidebar />
                                </nav>
                            </div>
                        </div>

                        <!-- Main Content -->
                        <div class="col-span-12 md:col-span-9 lg:col-span-10">
                            <div class="bg-white overflow-hidden rounded-lg shadow-sm border border-gray-100">
                                <div class="p-6">
                                    {{ $slot }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-indigo-800 text-indigo-200 text-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="mb-4 md:mb-0">
                            <p>&copy; {{ date('Y') }} Aimi An Najjah Tuition Center. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Scripts for mobile menu toggle -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const mobileMenuButton = document.querySelector('.mobile-menu-button');
                const mobileMenu = document.querySelector('.mobile-menu');
                
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            });
        </script>
    </body>
</html>