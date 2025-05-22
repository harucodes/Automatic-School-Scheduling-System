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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .bg-maroon-gradient {
            background: linear-gradient(135deg, #9b1a1a 0%, #5e1010 100%);
        }
    </style>
</head>

<body class="font-sans text-maroon-800 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-maroon-50">
        <a href="/">
            <div class="mb-8">

                <!-- Assuming you'll update the logo to match the color scheme -->
                <x-application-logo class="w-24 h-24" />
        </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-lg overflow-hidden sm:rounded-lg border border-maroon-200">
        {{ $slot }}
    </div>

    <!-- Optional footer -->
    <div class="mt-8 text-sm text-maroon-600">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
    </div>
</body>

</html>