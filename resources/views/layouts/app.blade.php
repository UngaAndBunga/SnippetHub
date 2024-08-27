<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <style>
.search-container input {
    border: none; /* Remove the border */
    box-shadow: none; /* Remove any shadow */
    outline: none; /* Remove the outline */
}
</style>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Snippet Hub') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <div
        wire:loading.delay
        class="fixed inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-green-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-red-500 rounded-full animate-bounce"></div>
        </div>
    </div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <livewire:layout.navigation />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <div class="flex">
                <aside class="w-1/4 p-4">
                    <livewire:followed-users />
                </aside>
                <main class="w-3/4 p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
