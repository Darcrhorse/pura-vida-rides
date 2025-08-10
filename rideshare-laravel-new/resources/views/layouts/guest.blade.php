<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Image Preloading for Auth Illustration -->
        <link rel="preload" as="image" href="{{ asset('images/auth-illustration.jpg') }}">

        <!-- Scripts -->
        @if(app()->environment('production'))
            <link rel="stylesheet" href="{{ asset('build/assets/app-BWrdByhk.css') }}">
            <script type="module" src="{{ asset('build/assets/app-CkOcBP1u.js') }}"></script>
            <script type="module" src="{{ asset('build/assets/axios-wu1k_jD9.js') }}"></script>
            <script type="module" src="{{ asset('build/assets/alpine-8kmaoRXL.js') }}"></script>
        @else
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        <!-- Google Places Autocomplete -->
        <script async src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps.key') }}&libraries=places&loading=async"></script>
        <script>
        document.addEventListener('DOMContentLoaded', () => {
            const opts = { componentRestrictions: { country: ['cr'] }, fields: ['geometry','name'] };
            const from = document.getElementById('from');
            const to = document.getElementById('to');
            if (from) new google.maps.places.Autocomplete(from, opts);
            if (to) new google.maps.places.Autocomplete(to, opts);
        });
        </script>
    </body>
</html>
