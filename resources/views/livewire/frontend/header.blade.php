<div>
    <section class="w-full">
        <div class="max-w-screen-2xl mx-auto px-10">
            <div class="flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-screen-2xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="#_"
                       class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">
                        <a href="{{ route('search.city', ['country' => $c]) }}"
                           class="{{ request()->routeIs('search.city') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Städte</a>
                        <a href="{{ route('search.lecturer', ['country' => $c]) }}"
                           class="{{ request()->routeIs('search.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Dozenten</a>
                        <a href="{{ route('search.venue', ['country' => $c]) }}"
                           class="{{ request()->routeIs('search.venue') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Veranstaltungs-Orte</a>
                        <a href="{{ route('search.course', ['country' => $c]) }}"
                           class="{{ request()->routeIs('search.course') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Kurse</a>
                    <a href="{{ route('search.event', ['country' => $c]) }}"
                           class="{{ request()->routeIs('search.event') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">Termine</a>
                    </nav>
                </div>
                @auth
                    <div></div>
                @else
                    <div class="inline-flex items-center ml-5 my-2 text-lg space-x-6 lg:justify-end">
                        <a href="{{ route('login') }}"
                           class="text-base font-medium leading-6 text-gray-400 hover:text-gray-300 whitespace-no-wrap transition duration-150 ease-in-out">
                            Login
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center justify-center px-4 py-2 font-medium leading-6 text-gray-200 hover:text-white whitespace-no-wrap bg-gray-800 border border-transparent rounded shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800">
                            Registrieren
                        </a>
                    </div>
                @endauth
            </div>
            <div class="flex lg:flex-row flex-col pt-4 md:pt-4 lg:pt-4">
                <div
                    class="w-full lg:w-1/2 flex lg:px-0 px-5 flex-col md:items-center lg:items-start justify-center -mt-12">

                    <h1 class="text-white text-3xl sm:text-5xl lg:max-w-none max-w-4xl lg:text-left text-left md:text-center xl:text-7xl font-black">
                        Bitcoin <span
                            class="bg-clip-text text-transparent bg-gradient-to-br from-yellow-400 via-yellow-500 to-yellow-700 mt-1 lg:block">School
                        </span> <br class="lg:block sm:hidden"> {{ str($country->name)->upper() }}
                    </h1>
                    <div>
                        <x-select
                            label="Land wechseln"
                            placeholder="Land wechseln"
                            wire:model="c"
                            :clearable="false"
                        >
                            <x-select.user-option src="{{ asset('vendor/blade-country-flags/4x3-de.svg') }}"
                                                  label="Deutschland" value="de"/>
                            <x-select.user-option src="{{ asset('vendor/blade-country-flags/4x3-at.svg') }}"
                                                  label="Österreich" value="at"/>
                            <x-select.user-option src="{{ asset('vendor/blade-country-flags/4x3-ch.svg') }}"
                                                  label="Schweiz" value="ch"/>
                        </x-select>
                    </div>
                    <p class="text-gray-500 sm:text-lg md:text-xl xl:text-2xl lg:max-w-none max-w-2xl md:text-center lg:text-left lg:pr-32 mt-6">
                        Finde Bitcoin Kurse in deiner City</p>
                    @php
                        $searchTitle = match ($currentRouteName) {
                            'search.city' => 'Stadt',
                            'search.lecturer' => 'Dozent',
                            'search.venue' => 'Veranstaltungs-Ort',
                            'search.course' => 'Kurs',
                            'search.event' => 'Termin',
                        };
                    @endphp
                    <a href="#_"
                       class="whitespace-nowrap bg-white px-12 lg:px-16 py-4 text-center lg:py-5 font-bold rounded text-lg md:text-xl lg:text-2xl mt-8 inline-block w-auto">
                        👇 {{ $searchTitle }} finden 👇
                    </a>
                    <p class="text-gray-400 font-normal mt-4">{{-- TEXT --}}</p>
                </div>
                <div
                    class="hidden lg:inline-flex lg:w-full lg:w-1/2 relative lg:mt-0 mt-20 flex items-center justify-center">
                    {{--<img src="https://cdn.devdojo.com/images/march2022/mesh-gradient1.png"
                         class="absolute lg:max-w-none max-w-3xl mx-auto mt-32 w-full h-full inset-0">--}}
                    <img src="{{ asset('img/btc-logo-6219386_1280.png') }}"
                         class="w-full md:w-auto w-72 max-w-md max-w-sm ml-4 md:ml-20 lg:ml-0 xl:max-w-lg relative">
                </div>
            </div>
        </div>
    </section>
</div>
