<div>
    <section class="w-full">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">
            <div
                class="relative sm:sticky sm:top-0 bg-21gray z-10 flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-screen-2xl">
                <div class="relative flex flex-col md:flex-row">
                    <a href="{{ route('welcome') }}"
                       class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                        <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                    </a>
                    <nav
                        class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">

                        <a href="{{ route('welcome') }}"
                           class="text-gray-400 mr-5 font-medium leading-6 hover:text-gray-300">
                            Zurück zur Übersicht
                        </a>

                        @if(str(request()->route()->getName())->contains('school.'))
                            <a href="{{ route('school.table.city', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('school.table.city') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Städte
                            </a>
                            <a href="{{ route('school.table.lecturer', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('school.table.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Dozenten
                            </a>
                            <a href="{{ route('school.table.venue', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('school.table.venue') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Veranstaltungs-Orte
                            </a>
                            <a href="{{ route('school.table.course', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('school.table.course') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Kurse
                            </a>
                            <a href="{{ route('school.table.event', ['country' => $c, '#table']) }}"
                               class="{{ request()->routeIs('school.table.event') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Termine
                            </a>
                        @endif
                        @if(str(request()->route()->getName())->contains('library.'))
                            <a href="{{ route('library.table.libraryItems', ['country' => $c]) }}"
                               class="{{ request()->routeIs('library.table.libraryItems') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Bibliothek
                            </a>
                            @if(auth()->user()?->is_lecturer)
                                <a href="{{ route('library.table.lecturer', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('library.table.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    Dozenten-Bibliothek
                                </a>
                            @endif
                        @endif
                        @if(str(request()->route()->getName())->contains('bookCases.'))
                            <a href="{{ route('bookCases.table.bookcases', ['country' => $c]) }}"
                               class="{{ request()->routeIs('bookCases.table.bookcases') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Bücher-Schränke
                            </a>
                        @endif
                        @if(str(request()->route()->getName())->contains('meetup.'))
                            <a href="{{ route('meetup.table.meetup', ['country' => $c]) }}"
                               class="{{ request()->routeIs('meetup.table.meetup') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Meetups
                            </a>
                            <a href="{{ route('meetup.table.meetupEvent', ['country' => $c]) }}"
                               class="{{ request()->routeIs('meetup.table.meetupEvent') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                Meetup-Termine
                            </a>
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
    <section class="h-auto">
        <div class="px-10 py-6 mx-auto max-w-7xl">
            <div class="w-full mx-auto text-left md:text-center">

                @if(str(request()->route()->getName())->contains('school.'))
                    <div>
                        <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoin <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">Kurse</span>
                            für deine<br class="lg:block hidden"> Reise in den Kaninchenbau.
                        </h1>
                        <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Wähle deine Stadt, suche im
                            Umkreis nach
                            Kursen und wähle ein für dich passendes Thema aus. </p>
                    </div>
                @endif

                @if(str(request()->route()->getName())->contains('library.'))
                    <div>
                        <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoin <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">Content</span>
                            für deine<br class="lg:block hidden"> Reise in den Kaninchenbau.
                        </h1>
                        <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Wähle ein für dich passendes
                            Thema aus. </p>
                    </div>
                @endif

                @if(str(request()->route()->getName())->contains('bookCases.'))
                    <div>
                        <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoin <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">Bücher-Schränke</span>
                            für deine<br class="lg:block hidden"> Reise in den Kaninchenbau.
                        </h1>
                        <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Suche einen öffentlichen
                            Bücher-Schrank aus. </p>
                    </div>
                @endif

                @if(str(request()->route()->getName())->contains('meetup.'))
                    <div>
                        <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoiner <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">Meetups</span><br class="lg:block hidden">
                            Plebs together strong 💪
                        </h1>
                        <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Finde Bitcoiner in deiner Stadt und lerne sie auf einem der Meetups kennen. </p>
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>
