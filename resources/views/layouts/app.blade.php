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
    <!-- Fonts -->
    @googlefonts
    <!-- Scripts -->
    <script src="https://mempool.space/mempool.js"></script>
    <script src="{{ asset('dist/jquery.js') }}"></script>
    <script src="{{ asset('vendor/jvector/jquery-jvectormap-2.0.5.min.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/world-mill.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/europe-merc.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/de.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/at.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/ch.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/fr.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/es.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/it.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/pt.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/pl.js') }}"></script>
    <script src="{{ asset('vendor/jvector/maps/se.js') }}"></script>
    <script src="{{ asset('dist/smoothscroll.js') }}"></script>
    <script src="https://kit.fontawesome.com/03bc14bd1e.js" crossorigin="anonymous"></script>
    @mapstyles
    @mapscripts
    <script src="{{ asset('dist/heatmap.min.js') }}"></script>
    <script src="{{ asset('dist/leaflet-heatmap.js') }}"></script>
    <script src="{{ asset('dist/leaflet-providers.js') }}"></script>
    <wireui:scripts/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/jvector/jquery-jvectormap-2.0.5.css') }}" type="text/css"
          media="screen"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <x-comments::styles/>
    <x-embed-styles/>
    @livewireStyles
    @include('layouts.styles')
</head>
<body class="font-sans antialiased {{ isset($darkModeDisabled) && $darkModeDisabled ? '' : 'bg-21gray' }} dark">
<x-notifications z-index="z-[99999]" blur="md" align="center"/>
<x-dialog z-index="z-[99999]" blur="md" align="center"/>
@if(auth()->user())
    {{-- HIGHSCORE-CHAT --}}
    <livewire:chat.highscore-chat/>
@endif
<livewire:laravel-echo/>
<x-jet-banner/>
<div class="min-h-screen">
    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
@stack('modals')
@livewireScripts
<!-- ProductLift SDK - Include it only once -->
<script defer src="https://bitcoin.productlift.dev/widgets_sdk"></script>
<x-comments::scripts/>
</body>
</html>
