<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" href="/img/apple_touch_icon.png"/>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    {!! seo($SEOData ?? null) !!}
    <!-- Fonts -->
    @googlefonts
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('vendor/jvector/jquery-jvectormap-2.0.5.css') }}" type="text/css"
          media="screen"/>
    <script src="https://unpkg.com/jquery"></script>
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
    <script src="https://kit.fontawesome.com/03bc14bd1e.js" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
    @mapscripts
    <wireui:scripts/>
    <x-comments::scripts />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    <x-comments::styles />
    @livewireStyles
    @mapstyles
    <style>
        .comments {
            --comments-color-background: rgb(34, 34, 34);
            --comments-color-background: rgb(34, 34, 34);
            --comments-color-background-nested: rgb(34, 34, 34);
            --comments-color-background-paper: rgb(55, 51, 51);
            --comments-color-background-info: rgb(104, 89, 214);

            --comments-color-reaction: rgb(59, 59, 59);
            --comments-color-reaction-hover: rgb(65, 63, 63);
            --comments-color-reacted: rgba(67, 56, 202, 0.25);
            --comments-color-reacted-hover: rgba(67, 56, 202, 0.5);

            --comments-color-border: rgb(221, 221, 221);

            --comments-color-text:white;
            --comments-color-text-dimmed: rgb(164, 164, 164);
            --comments-color-text-inverse: white;

            --comments-color-accent: rgba(67, 56, 202);
            --comments-color-accent-hover: rgba(67, 56, 202, 0.75);

            --comments-color-danger: rgb(225, 29, 72);
            --comments-color-danger-hover: rgb(225, 29, 72, 0.75);

            --comments-color-success: rgb(10, 200, 134);
            --comments-color-success-hover: rgb(10, 200, 134, 0.75);

            --comments-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }
        .comments-button {
            background-color: #F7931A !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-21gray dark">
<x-notifications z-index="z-50" blur="md" align="center"/>
<x-jet-banner/>
<div class="min-h-screen">
    @auth
        @livewire('navigation-menu')
    @endauth
    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif
    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
@stack('modals')
@livewireScripts
</body>
</html>
