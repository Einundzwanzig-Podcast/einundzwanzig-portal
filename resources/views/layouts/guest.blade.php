<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    @googlefonts
    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/03bc14bd1e.js" crossorigin="anonymous"></script>
    <wireui:scripts/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-21gray dark">
<x-notifications z-index="z-50"/>
{{ $slot }}
@stack('modals')
@livewireScripts
</body>
</html>
