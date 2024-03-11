<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Template Stylesheet -->
        @vite(['resources/css/app.css', 'resources/js/app.js', ])

    <!-- Scripts -->

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-white">


    <!-- Page Content -->
    <main id="app" class="bg-gray-50 p-5 rounded-xl">
        <livewire:package.calculator/>
    </main>
</div>
</body>
</html>
