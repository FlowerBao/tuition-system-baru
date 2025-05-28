<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('logo.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-green-100 via-white to-blue-100 font-sans text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col justify-center items-center px-4 sm:px-6 lg:px-8">
        <!-- Logo -->
        <div class="mb-4">
            <a href="/">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Tuition Centre Logo" class="w-48 sm:w-60 mx-auto">
            </a>
        </div>

    

        <!-- Form Card -->
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg px-6 py-8">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
