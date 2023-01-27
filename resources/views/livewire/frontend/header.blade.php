<div>
    <section class="w-full">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">
            <div
                class="relative sm:sticky sm:top-0 bg-21gray z-10 flex flex-col flex-wrap items-center justify-between py-7 mx-auto md:flex-row max-w-screen-2xl space-y-4">
                <div>
                    <div class="relative flex flex-col md:flex-row">
                        <a href="{{ route('welcome', ['c' => $c, 'l' => $l]) }}"
                           class="flex items-center mb-5 font-medium text-gray-900 lg:w-auto lg:items-center lg:justify-center md:mb-0">
                            <img src="{{ asset('img/einundzwanzig-horizontal-inverted.svg') }}">
                        </a>
                        <nav
                            class="flex flex-wrap items-center mb-5 text-lg md:mb-0 md:pl-8 md:ml-8 md:border-l md:border-gray-800">

                            @if(!str(request()->route()->getName())->contains('.view'))
                                <a href="{{ route('welcome', ['c' => $c]) }}"
                                   class="text-gray-400 mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Back to the overview') }}
                                </a>
                            @elseif(str(request()->route()->getName())->contains('article.view'))
                                <a href="{{ route('article.overview') }}"
                                   class="text-gray-400 mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Back to the overview') }}
                                </a>
                            @elseif(str(request()->route()->getName())->contains('libraryItem.view'))
                                <a href="{{ route('library.table.libraryItems', ['country' => $country]) }}"
                                   class="text-gray-400 mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Back to the overview') }}
                                </a>
                            @endif

                            @if(str(request()->route()->getName())->contains('school.'))
                                <a href="{{ route('school.table.city', ['country' => $c, '#table']) }}"
                                   class="{{ request()->routeIs('school.table.city') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Cities') }}
                                </a>
                                <a href="{{ route('school.table.lecturer', ['country' => $c, '#table']) }}"
                                   class="{{ request()->routeIs('school.table.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Lecturers') }}
                                </a>
                                <a href="{{ route('school.table.venue', ['country' => $c, '#table']) }}"
                                   class="{{ request()->routeIs('school.table.venue') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Venues') }}
                                </a>
                                <a href="{{ route('school.table.course', ['country' => $c, '#table']) }}"
                                   class="{{ request()->routeIs('school.table.course') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Courses') }}
                                </a>
                                <a href="{{ route('school.table.event', ['country' => $c, '#table']) }}"
                                   class="{{ request()->routeIs('school.table.event') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Events') }}
                                </a>
                            @endif
                            @if(str(request()->route()->getName())->contains('library.'))
                                <a href="{{ route('library.table.libraryItems', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('library.table.libraryItems') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Library') }}
                                </a>
                                @if(auth()->user()?->is_lecturer)
                                    <a href="{{ route('library.table.lecturer', ['country' => $c]) }}"
                                       class="{{ request()->routeIs('library.table.lecturer') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                        {{ __('Library for lecturers') }}
                                    </a>
                                @endif
                            @endif
                            @if(str(request()->route()->getName())->contains('bookCases.'))
                                <a href="{{ route('bookCases.table.city', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('bookCases.table.city') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('City search') }}
                                </a>
                                <a href="{{ route('bookCases.table.bookcases', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('bookCases.table.bookcases') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Bookcases') }}
                                </a>
                                <a href="https://openbookcase.de/" target="_blank"
                                   class="text-gray-400 mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Submit new book case') }}
                                </a>
                            @endif
                            @if(str(request()->route()->getName())->contains('meetup.'))
                                <a href="{{ route('meetup.world', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('meetup.world') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('World map') }}
                                </a>
                                <a href="{{ route('meetup.table.meetup', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('meetup.table.meetup') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Meetups') }}
                                </a>
                                <a href="{{ route('meetup.table.meetupEvent', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('meetup.table.meetupEvent') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Meetup dates') }}
                                </a>
                            @endif
                            @if(str(request()->route()->getName())->contains('bitcoinEvent.'))
                                <a href="{{ route('bitcoinEvent.table.bitcoinEvent', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('bitcoinEvent.table.bitcoinEvent') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Events') }}
                                </a>
                            @endif
                            @if(auth()->check())
                                <a href="{{ route('bookCases.highScoreTable', ['country' => $c]) }}"
                                   class="{{ request()->routeIs('bookCases.highScoreTable') ? 'text-amber-500 underline' : 'text-gray-400' }} mr-5 font-medium leading-6 hover:text-gray-300">
                                    {{ __('Highscore Table') }}
                                </a>
                            @endif

                        </nav>
                    </div>
                </div>
                <div class="flex space-x-2 justify-end w-full items-end">
                    <x-native-select
                        label="{{ __('Change country') }}"
                        wire:model="c"
                        option-label="name"
                        option-value="code"
                        :options="$countries"
                    />
                    <x-select
                        label="{{ __('Change language') }}"
                        placeholder="{{ __('Change language') }}"
                        wire:model="l"
                        :clearable="false"
                        :searchable="true"
                        :async-data="route('api.languages.index')"
                        option-label="name"
                        option-value="language"
                    />
                    @auth
                        <div></div>
                    @else
                        <x-button href="{{ route('auth.ln') }}">
                            <i class="fa-thin fa-sign-in"></i>
                            {{ __('Login') }}
                        </x-button>
                    @endauth
                </div>
            </div>
        </div>
    </section>
    <section class="h-auto">
        <div class="px-10 py-2 mx-auto max-w-7xl">
            <div class="w-full mx-auto text-left md:text-center">

                @if(str(request()->route()->getName())->contains('school.') && !str(request()->route()->getName())->contains('landingPage.'))
                    <div>
                        <h1 class="mb-2 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoin <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">{{ __('Courses') }}</span>
                        </h1>
                        <p class="px-0 mb-2 text-lg text-gray-600 md:text-xl lg:px-24">
                            {{ __('Choose your city, search for courses in the surrounding area and select a topic that suits you.') }}
                        </p>
                    </div>
                @endif

                @if(str(request()->route()->getName())->contains('library.'))
                    <div>
                        <h1 class="mb-2 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                            Bitcoin <span
                                class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">{{ __('Content') }}</span>
                        </h1>
                        <p class="px-0 mb-2 text-lg text-gray-600 md:text-xl lg:px-24">
                            {{ __('Choose a topic that is right for you.') }}
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </section>
</div>
