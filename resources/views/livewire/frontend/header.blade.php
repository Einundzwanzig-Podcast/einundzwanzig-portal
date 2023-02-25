<header x-data="{ open: false }" @keydown.window.escape="open = false" class="relative isolate z-10 bg-white mb-4">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
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

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('News') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">News</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('article.overview') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-newspaper flex-none text-gray-400"></i>
                                            {{ __('News Article') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('news.form') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Submit news articles') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent news article</h3>

                            @foreach($news as $item)
                                <article wire:key="library_item_{{ $item->id }}"
                                         class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <a href="{{ route('article.view', ['libraryItem' => $item]) }}">
                                            <img
                                                class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                                src="{{ $item->getFirstMediaUrl('main') }}"
                                                alt="{{ $item->name }}">
                                        </a>
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->created_at->asDateTime() }}
                                            </time>
                                            <div
                                                class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">
                                                {{ $item->lecturer->name }}
                                            </div>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="{{ route('article.view', ['libraryItem' => $item]) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->name }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                            {{ $item->excerpt }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('Meetups') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Meetups</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('meetup.world', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-globe flex-none text-gray-400"></i>
                                            {{ __('World map') }}
                                        </a>

                                        <a href="{{ route('meetup.table.meetup', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-people-group flex-none text-gray-400"></i>
                                            {{ __('Meetups') }}
                                        </a>

                                        <a href="{{ route('meetup.table.meetupEvent', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-calendar flex-none text-gray-400"></i>
                                            {{ __('Meetup dates') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('meetup.meetup.form', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Submit Meetup') }}
                                        </a>

                                        <a href="{{ route('meetup.event.form', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Register Meetup date') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent posts</h3>

                            @foreach($meetups as $item)
                                <article
                                    class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <img
                                            class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                            src="{{ $item->meetup->getFirstMediaUrl('logo') }}"
                                            alt="">
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->meetup->users->count() }} {{ __('Participants') }}
                                            </time>
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->start->asDateTime() }}
                                            </time>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="{{ route('meetup.event.landing', ['country' => $item->meetup->city->country, 'meetupEvent' => $item]) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->meetup->name }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                            {{ $item->location }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('Courses') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Kurse</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('school.table.city', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-city flex-none text-gray-400"></i>
                                            {{ __('Cities') }}
                                        </a>

                                        <a href="{{ route('school.table.lecturer', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-chalkboard-user flex-none text-gray-400"></i>
                                            {{ __('Lecturers') }}
                                        </a>

                                        <a href="{{ route('school.table.venue', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-building flex-none text-gray-400"></i>
                                            {{ __('Venues') }}
                                        </a>

                                        <a href="{{ route('school.table.course', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-screen-users flex-none text-gray-400"></i>
                                            {{ __('Courses') }}
                                        </a>

                                        <a href="{{ route('school.table.event', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-calendar flex-none text-gray-400"></i>
                                            {{ __('Course Events') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('contentCreator.form') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Register lecturer') }}
                                        </a>

                                        <a href="{{ route('venue.form') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Create venue') }}
                                        </a>

                                        <a href="/nova/resources/courses"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Register course') }}
                                        </a>

                                        <a href="/nova/resources/course-events"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Register course date') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent posts</h3>

                            @foreach($courseEvents as $item)
                                <article
                                    class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <img
                                            class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                            src="{{ $item->course->lecturer->getFirstMediaUrl('avatar') }}"
                                            alt="{{ $item->course->lecturer->name }}">
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->from->asDateTime() }}
                                            </time>
                                            <div
                                                class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">{{ $item->course->lecturer->name }}</div>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="#">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->course->name }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                            {{ $item->course->description }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('Library') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">{{ __('Library') }}</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('library.table.libraryItems', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-search flex-none text-gray-400"></i>
                                            {{ __('Search') }}
                                        </a>

                                        @auth
                                            <a href="{{ route('library.table.lecturer', ['country' => $country]) }}"
                                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                                <i class="fa-thin fa-school flex-none text-gray-400"></i>
                                                {{ __('Library for lecturers') }}
                                            </a>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('library.libraryItem.form', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Submit contents') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent posts</h3>

                            @foreach($libraryItems as $item)
                                <article
                                    class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <img
                                            class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                            src="{{ $item->getFirstMediaUrl('main') }}"
                                            alt="">
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <div
                                                class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">
                                                {{ $item->lecturer->name }}
                                            </div>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="{{ route('libraryItem.view', ['libraryItem' => $item]) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->name }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                            {{ $item->excerpt }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('Events') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Engagement</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('bitcoinEvent.table.bitcoinEvent', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-calendar-lines-pen flex-none text-gray-400"></i>
                                            {{ __('Events') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('venue.form') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Create venue') }}
                                        </a>

                                        <a href="{{ route('bitcoinEvent.form') }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Register event') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent posts</h3>

                            @foreach($bitcoinEvents as $item)
                                <article
                                    class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <img
                                            class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                            src="{{ $item->getFirstMediaUrl('logo') }}"
                                            alt="{{ $item->title }}">
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->from->asDateTime('d.m.Y') }}
                                            </time>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="{{ $item->link }}" target="_blank">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->title }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600 truncate">
                                            {{ $item->venue->name}}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            <div x-data="Components.popover({ open: false, focus: false })" x-init="init()" @keydown.escape="onEscape"
                 @close-popover-group.window="onClosePopoverGroup">
                <button type="button" class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                        @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                        :aria-expanded="open.toString()">
                    {{ __('Bookcases') }}
                    <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                         aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-description="'Product' flyout menu, show/hide based on flyout menu state."
                     class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                     x-ref="panel" @click.away="open = false">
                    <div class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                        <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Bücherschränke</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="{{ route('bookCases.table.city', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-city flex-none text-gray-400"></i>
                                            {{ __('City search') }}
                                        </a>

                                        <a href="{{ route('bookCases.table.bookcases', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-book flex-none text-gray-400"></i>
                                            {{ __('Bookcases') }}
                                        </a>

                                        <a href="{{ route('bookCases.world', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-map flex-none text-gray-400"></i>
                                            {{ __('World map') }}
                                        </a>

                                        <a href="{{ route('bookCases.heatmap', ['country' => $country]) }}"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-heat flex-none text-gray-400"></i>
                                            {{ __('Heatmap') }}
                                        </a>

                                        @auth
                                            <a href="{{ route('bookCases.highScoreTable', ['country' => $country]) }}"
                                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                                <i class="fa-thin fa-star flex-none text-gray-400"></i>
                                                {{ __('Highscore Table') }}
                                            </a>
                                        @endauth

                                    </div>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                <div class="mt-6 flow-root">
                                    <div class="-my-2">

                                        <a href="https://openbookcase.de/" target="_blank"
                                           class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                            <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                            {{ __('Submit new book case') }}
                                        </a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                            <h3 class="sr-only">Recent posts</h3>

                            @foreach($orangePills as $item)
                                <article
                                    class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                    <div class="relative flex-none">
                                        <img
                                            class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                            src="{{ $item->getFirstMediaUrl('images') }}"
                                            alt="{{ $item->bookCase->title }}">
                                        <div
                                            class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-x-4">
                                            <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                {{ $item->date->asDateTime() }}
                                            </time>
                                            <div
                                                class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">
                                                {{ $item->user->name }}
                                            </div>
                                        </div>
                                        <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                            <a href="{{ route('bookCases.comment.bookcase', ['country' => $country, 'bookCase' => $item]) }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->bookCase->title }}
                                            </a>
                                        </h4>
                                        <p class="mt-2 text-sm leading-6 text-gray-600">
                                            {{ $item->bookCase->address }}
                                        </p>
                                    </div>
                                </article>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>

            @auth
                <div x-data="Components.popover({ open: false, focus: false })" x-init="init()"
                     @keydown.escape="onEscape"
                     @close-popover-group.window="onClosePopoverGroup">
                    <button type="button"
                            class="flex items-center gap-x-1 text-sm font-semibold leading-6 text-gray-900"
                            @click="toggle" @mousedown="if (open) $event.preventDefault()" aria-expanded="true"
                            :aria-expanded="open.toString()">
                        {{ __('My profile') }}
                        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                             aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                  clip-rule="evenodd"></path>
                        </svg>
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-1"
                         x-description="'Product' flyout menu, show/hide based on flyout menu state."
                         class="absolute inset-x-0 top-0 -z-10 bg-white pt-16 shadow-lg ring-1 ring-gray-900/5"
                         x-ref="panel" @click.away="open = false">
                        <div
                            class="mx-auto grid max-w-7xl grid-cols-1 gap-y-10 gap-x-8 py-10 px-6 lg:grid-cols-2 lg:px-8">
                            <div class="grid grid-cols-2 gap-x-6 sm:gap-x-8">
                                <div>
                                    <h3 class="text-sm font-medium leading-6 text-gray-500">{{ __('My profile') }}</h3>
                                    <div class="mt-6 flow-root">
                                        <div class="-my-2">

                                            <a href="{{ route('profile.show') }}"
                                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                                <i class="fa-thin fa-city flex-none text-gray-400"></i>
                                                {{ __('My profile') }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium leading-6 text-gray-500">Admin</h3>
                                    <div class="mt-6 flow-root">
                                        <div class="-my-2">

                                            <a href="{{ route('profile.wallet') }}"
                                               class="flex gap-x-4 py-2 text-sm font-semibold leading-6 text-gray-900">
                                                <i class="fa-thin fa-plus flex-none text-gray-400"></i>
                                                {{ __('Change lightning wallet/pubkey') }}
                                            </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-10 sm:gap-8 lg:grid-cols-2">
                                <h3 class="sr-only">Recent posts</h3>

                                {{--@foreach($orangePills as $item)
                                    <article
                                        class="relative isolate flex max-w-2xl flex-col gap-x-8 gap-y-6 sm:flex-row sm:items-start lg:flex-col lg:items-stretch">
                                        <div class="relative flex-none">
                                            <img
                                                class="aspect-[2/1] w-full rounded-lg bg-gray-100 object-cover sm:aspect-[16/9] sm:h-32 lg:h-auto"
                                                src="{{ $item->getFirstMediaUrl('images') }}"
                                                alt="{{ $item->bookCase->title }}">
                                            <div
                                                class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-x-4">
                                                <time datetime="2023-03-16" class="text-sm leading-6 text-gray-600">
                                                    {{ $item->date->asDateTime() }}
                                                </time>
                                                <div
                                                    class="relative z-10 rounded-full bg-gray-50 py-1.5 px-3 text-xs font-medium text-gray-600 hover:bg-gray-100">
                                                    {{ $item->user->name }}
                                                </div>
                                            </div>
                                            <h4 class="mt-2 text-sm font-semibold leading-6 text-gray-900">
                                                <a href="#">
                                                    <span class="absolute inset-0"></span>
                                                    {{ $item->bookCase->title }}
                                                </a>
                                            </h4>
                                            <p class="mt-2 text-sm leading-6 text-gray-600">
                                                {{ $item->bookCase->address }}
                                            </p>
                                        </div>
                                    </article>
                                @endforeach--}}

                            </div>
                        </div>
                    </div>
                </div>
            @endauth

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
         aria-modal="true" style="display: none;">
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
                                 x-show="open" style="display: none;">
                                <a href="{{ route('article.overview') }}"
                                   class="block rounded-lg py-2 pl-6 pr-3 text-sm font-semibold leading-7 text-gray-900 hover:bg-gray-50">{{ __('News Article') }}</a>
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
                                 x-show="open" style="display: none;">
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
                                 x-show="open" style="display: none;">
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
                                 x-show="open" style="display: none;">
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
                                 x-show="open" style="display: none;">
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
                                 x-show="open" style="display: none;">
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
                                     x-show="open" style="display: none;">
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
