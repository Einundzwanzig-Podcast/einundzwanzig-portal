<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="/img/apple_touch_icon.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @stack('feeds')
    {!! seo($SEOData ?? null) !!}
    {{-- Fonts --}}
    @googlefonts
    {{-- Scripts --}}
    <script src="https://kit.fontawesome.com/866fd3d0ab.js" crossorigin="anonymous"></script>
    <wireui:scripts/>
    <x-embed-styles/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Styles --}}
    @livewireStyles
    @include('components.layouts.styles')
</head>
<body class="font-sans antialiased">
<x-notifications z-index="z-[99999]" blur="md" align="center"/>
<x-dialog z-index="z-[99999]" blur="md" align="center"/>
<livewire:laravel-echo/>
<x-jet-banner/>
{{ $slot }}
@stack('modals')
@livewireScripts
</body>
</html>
