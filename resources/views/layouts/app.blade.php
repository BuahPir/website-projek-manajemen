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
    </head>
    <body class="font-sans antialiased"
        x-data= "{ darkMode: localStorage.getItem('dark') == true }"
        x-init= "$watch('darkMode', val => localStorage.setItem('dark', val))"
        x-bind:class="{'dark': darkMode}"
    >
        <div class="h-0 bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Content -->
            <main class="py-5 lg:pl-72">
                <div class="px-4 sm:px-6 lg:px-8">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
