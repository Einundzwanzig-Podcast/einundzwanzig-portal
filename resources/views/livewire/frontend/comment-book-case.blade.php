<div class="bg-21gray flex flex-col h-screen justify-between">
    <script src="{{ asset('earth/miniature.earth.js') }}"></script>
    <style>
        .earth-container::after {
            content: "";
            position: absolute;
            height: 22%;
            bottom: 4%;
            left: 13%;
            right: 13%;
        }
    </style>
    {{-- HEADER --}}
    <div>
        <section class="w-full">
            <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">
                <div
                    class="relative sm:sticky sm:top-0 bg-21gray z-10 flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-screen-2xl">
                    <div class="relative flex flex-col md:flex-row">
                        <a href="{{ route('search.city', ['country' => $c]) }}"
                           class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                            <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                        </a>
                        <nav
                            class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">
                            <a href="{{ route('search.city', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('search.city') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Städte</a>
                            <a href="{{ route('search.lecturer', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('search.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Dozenten</a>
                            <a href="{{ route('search.venue', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('search.venue') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Veranstaltungs-Orte</a>
                            <a href="{{ route('search.course', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('search.course') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Kurse</a>
                            <a href="{{ route('search.event', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('search.event') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Termine</a>
                            <a href="{{ route('library', ['country' => $c]) }}"
                               class="{{ request()->routeIs('library') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Bibliothek</a>
                            <a href="{{ route('search.bookcases', ['country' => $c]) }}"
                               class="{{ request()->routeIs('search.bookcases') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Bücher-Schränke</a>
                            @if(auth()->user()?->is_lecturer)
                                <a href="{{ route('library.lecturer', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('library.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Dozenten-Bibliothek</a>
                            @endif
                        </nav>
                    </div>
                    @auth
                        <div></div>
                    @else
                        <div class="inline-flex items-center ml-5 my-2 text-lg space-x-6 lg:justify-end">
                            <a href="{{ route('auth.ln') }}"
                               class="text-xs sm:text-base font-medium leading-6 text-gray-400 hover:text-gray-300 whitespace-no-wrap transition duration-150 ease-in-out">
                                Login
                            </a>
                            <a href="{{ route('auth.ln') }}"
                               class="text-xs sm:text-base inline-flex items-center justify-center px-4 py-2 font-medium leading-6 text-gray-200 hover:text-white whitespace-no-wrap bg-gray-800 border border-transparent rounded shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                                Registrieren
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </section>
    </div>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">
            <div class="flex items-center justify-end space-x-2 my-6">
                <x-button primary :href="route('search.bookcases', ['country' => $c])">
                    <i class="fa fa-thin fa-arrow-left"></i>
                    Zurück zur Übersicht
                </x-button>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div
                    class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                    {{--<div class="flex-shrink-0">
                        <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                    </div>--}}
                    <div class="min-w-0 flex-1">
                        <div class="focus:outline-none">
                            <p class="text-sm font-medium text-gray-900">Name</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->title }}</p>
                            <p class="text-sm font-medium text-gray-900">Link</p>
                            <p class="text-sm text-gray-500">
                                <a target="_blank"
                                   href="{{ $this->url_to_absolute($bookCase->homepage) }}">{{ $this->url_to_absolute($bookCase->homepage) }}</a>
                            </p>
                            <p class="text-sm font-medium text-gray-900">Adresse</p>
                            <p class="truncate text-sm text-gray-500">{{ $bookCase->address }}</p>
                        </div>
                    </div>
                </div>

                <div class="rounded">
                    @map([
                    'lat' => $bookCase->lat,
                    'lng' => $bookCase->lon,
                    'zoom' => 24,
                    'markers' => [
                    [
                    'title' => $bookCase->title,
                    'lat' => $bookCase->lat,
                    'lng' => $bookCase->lon,
                    'url' => 'https://gonoware.com',
                    'icon' => asset('img/btc-logo-6219386_1280.png'),
                    'icon_size' => [42, 42],
                    ],
                    ],
                    ])
                </div>

            </div>

            <div class="my-4">
                <livewire:comments :model="$bookCase"/>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
