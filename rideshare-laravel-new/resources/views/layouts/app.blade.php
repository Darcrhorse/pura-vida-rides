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

        <!-- Image Preloading for LCP Optimization -->
        <link rel="preload" as="image" href="{{ asset('images/hero-index.jpg') }}"
              imagesrcset="{{ asset('images/hero-index.jpg') }} 1920w, {{ asset('images/results-strip.jpg') }} 1280w"
              imagesizes="(min-width:1024px) 100vw, 100vw">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
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
