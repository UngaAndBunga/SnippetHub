<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Snippet Hub</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
    <div
        wire:loading.delay
        class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-green-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-red-500 rounded-full animate-bounce"></div>
        </div>
    </div>
    <div class="relative min-h-screen bg-gray-100 dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        @if (Route::has('login'))
            <livewire:welcome.navigation />
        @endif

        <!-- Centered search component -->
        <div class="flex justify-center pt-6">
            <div class="w-full max-w-4xl px-4">
                <livewire:search search=""/>
            </div>
        </div>

        <main class="p-6">
            {{ $slot }}
        </main>
    </div>
    </body>
</html>
