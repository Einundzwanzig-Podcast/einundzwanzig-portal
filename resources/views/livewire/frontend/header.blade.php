<header x-data="{ open: false }" @keydown.window.escape="open = false" class="relative isolate z-10 bg-white mb-4">
    <nav class="mx-auto flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Einundzwanzig Portal</span>
                <img class="h-12 w-auto" src="{{ asset('img/einundzwanzig.png') }}" alt="Logo">
            </a>
        </div>
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700"
                    @click="open = true">
                <span class="sr-only">Open main menu</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                     aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12" x-data="Components.popoverGroup()" x-init="init()">

            @include('livewire.frontend.navigation.news')

            @include('livewire.frontend.navigation.meetups')

            @include('livewire.frontend.navigation.courses')

            @include('livewire.frontend.navigation.library')

            @include('livewire.frontend.navigation.events')

            @include('livewire.frontend.navigation.bookcases')

            @auth
                @include('livewire.frontend.navigation.profile')
            @endauth

            @include('livewire.frontend.navigation.settings')

        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            @if(!auth()->check())
                <a href="{{ route('auth.ln') }}" class="text-sm font-semibold leading-6 text-gray-900">Log in <span
                        aria-hidden="true">→</span></a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button secondary type="submit"
                            class="-mx-3 block rounded-lg py-2.5 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                        <i class="fa-thin fa-sign-out"></i>
                        {{ __('Logout') }}
                    </button>
                </form>
            @endif
        </div>
    </nav>
    <div x-description="Mobile menu, show/hide based on menu open state." class="lg:hidden" x-ref="dialog" x-show="open"
         aria-modal="true" style="display: none;" x-cloak>
        <div x-description="Background backdrop, show/hide based on slide-over state." class="fixed inset-0 z-10"></div>
        <div
            class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10"
            @click.away="open = false">
            <div class="flex items-center justify-between">
                <a href="#" class="-m-1.5 p-1.5">
                    <span class="sr-only">Einundzwanzig Portal</span>
                    <img class="h-8 w-auto" src="{{ asset('img/einundzwanzig.png') }}" alt="Logo">
                </a>
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700" @click="open = false">
                    <span class="sr-only">Close menu</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('News') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('article.overview') }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('News Article') }}</a>
                                <a href="{{ route('school.table.lecturer', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Manage content creators') }}</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('Meetups') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('meetup.world', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('World map') }}</a>
                                <a href="{{ route('meetup.table.meetup', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Meetups') }}</a>
                                <a href="{{ route('meetup.table.meetupEvent', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Meetup dates') }}</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('Events') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('bitcoinEvent.table.bitcoinEvent', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Events') }}</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('Courses') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('school.table.city', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('City search') }}</a>
                                <a href="{{ route('school.table.course', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Courses') }}</a>
                                <a href="{{ route('school.table.venue', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Venues') }}</a>
                                <a href="{{ route('school.table.lecturer', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Lecturers') }}</a>
                                <a href="{{ route('school.table.event', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Course Events') }}</a>
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('Library') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('library.table.libraryItems', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Search') }}</a>
                                @auth
                                    <a href="{{ route('library.table.lecturer', ['country' => $country]) }}"
                                       class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Library for lecturers') }}</a>
                                @endauth
                            </div>
                        </div>

                        <div x-data="{ open: false }" class="-mx-3">
                            <button type="button"
                                    class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                    aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                    x-bind:aria-expanded="open.toString()">
                                {{ __('Bookcases') }}
                                <svg class="h-5 w-5 flex-none"
                                     x-description="Expand/collapse icon, toggle classes based on menu open state."
                                     x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                          d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <div class="mt-2 space-y-2"
                                 x-description="'Product' sub-menu, show/hide based on menu state." id="disclosure-1"
                                 x-show="open" style="display: none;" x-cloak>
                                <a href="{{ route('bookCases.table.city', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('City search') }}</a>
                                <a href="{{ route('bookCases.table.bookcases', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Bookcases') }}</a>
                                <a href="{{ route('bookCases.world', ['country' => $country]) }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('World map') }}</a>
                                @auth
                                    <a href="{{ route('bookCases.highScoreTable', ['country' => $country]) }}"
                                       class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Highscore Table') }}</a>
                                @endauth
                            </div>
                        </div>

                        @auth
                            <div x-data="{ open: false }" class="-mx-3">
                                <button type="button"
                                        class="flex w-full items-center justify-between rounded-lg py-2 pl-3 pr-3.5 text-base font-semibold leading-7 hover:bg-gray-50"
                                        aria-controls="disclosure-1" @click="open = !open" aria-expanded="false"
                                        x-bind:aria-expanded="open.toString()">
                                    {{ __('My profile') }}
                                    <svg class="h-5 w-5 flex-none"
                                         x-description="Expand/collapse icon, toggle classes based on menu open state."
                                         x-state:on="Open" x-state:off="Closed" :class="{ 'rotate-180': open }"
                                         viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                <div class="mt-2 space-y-2"
                                     x-description="'Product' sub-menu, show/hide based on menu state."
                                     id="disclosure-1"
                                     x-show="open" style="display: none;" x-cloak>
                                    <a href="{{ route('profile.show') }}"
                                       class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('My profile') }}</a>
                                    <a href="{{ route('profile.wallet') }}"
                                       class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('Change lightning wallet/pubkey') }}</a>
                                </div>
                            </div>
                        @endauth

                    </div>
                    <div class="py-6">
                        @if(!auth()->check())
                            <a href="{{ route('auth.ln') }}"
                               class="-mx-3 block rounded-lg py-2.5 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">Log
                                in</a>
                        @else
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button secondary type="submit"
                                        class="-mx-3 block rounded-lg py-2.5 px-3 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                                    <i class="fa-thin fa-sign-out"></i>
                                    {{ __('Logout') }}
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
