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
        #seekObjContainer {
            position: relative;
            width: 400px;
            margin: 0 5px;
            height: 5px;
        }

        #seekObj {
            position: relative;
            width: 100%;
            height: 100%;
            background-color: #e3e3e3;
            border: 1px solid black;
        }

        #percentage {
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            background-color: coral;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="font-sans antialiased bg-21gray dark">
<x-notifications z-index="z-50"/>
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
<div
    x-data="{

    }"
    class="hidden fixed bottom-0 w-full flex items-center gap-6 bg-white py-4 px-4 md:px-6">
    <audio x-ref="audio">
        <source src="https://thenewcode.com/assets/audio/24-ghosts-III.mp3" type="audio/mp3">
    </audio>
    <div class="hidden md:block">
        <x-button primary @click="togglePlay"><i class="fa fa-thin fa-play"></i></x-button>
    </div>
    <div
        class="mb-[env(safe-area-inset-bottom)] flex flex-1 flex-col gap-3 overflow-hidden p-1 justify-center items-center">
        <div
            class="truncate text-center text-sm font-bold leading-6 md:text-left"
        >
            PLAYER
        </div>
        <div class="flex justify-between gap-6">
            <div class="md:hidden">
                <x-button primary @click="togglePlay"><i class="fa fa-thin fa-play"></i></x-button>
            </div>
        </div>
    </div>
</div>
@stack('modals')
@livewireScripts
</body>
</html>
