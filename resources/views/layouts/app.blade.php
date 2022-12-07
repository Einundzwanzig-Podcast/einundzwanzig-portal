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
