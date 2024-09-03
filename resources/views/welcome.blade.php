<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Snippet Hub</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
<x-loading-screen/>
<div class="relative min-h-screen bg-gray-900 selection:bg-red-500 selection:text-white m-0">
    @if (Route::has('login'))
        <div>
            <livewire:welcome.navigation/>
        </div>
    @endif

    <!-- Centered search component -->
    <div class="flex justify-center pt-6">
        <div class=" max-w-4xl px-4">
            <livewire:search search=""/>
        </div>
    </div>
    <div>
        <livewire:trending-posts/>
    </div>
</div>
</body>
</html>
