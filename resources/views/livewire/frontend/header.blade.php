<header x-data="{ open: false }" @keydown.window.escape="open = false" class="relative isolate z-10 bg-white mb-4">
    <nav class="mx-auto flex items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:flex-1">
            <a href="/" class="-m-1.5 p-1.5">
                <span class="sr-only">Einundzwanzig Portal</span>
                <img class="h-2 sm:h-4 w-auto" src="{{ asset('img/einundzwanzig-horizontal.svg') }}" alt="Logo">
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
        <div class="hidden lg:flex lg:gap-x-8" x-data="Components.popoverGroup()" x-init="init()">

            @include('livewire.frontend.navigation.news')

            @include('livewire.frontend.navigation.meetups')

            @include('livewire.frontend.navigation.courses')

            @include('livewire.frontend.navigation.library')

            @include('livewire.frontend.navigation.events')

            @include('livewire.frontend.navigation.bookcases')

            @include('livewire.frontend.navigation.association')

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
                        <i class="fa-solid fa-sign-out"></i>
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
                    <img class="h-2 sm:h-4 w-auto" src="{{ asset('img/einundzwanzig-horizontal.svg') }}" alt="Logo">
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

                        @include('livewire.frontend.navigation_mobile.news')
                        @include('livewire.frontend.navigation_mobile.meetups')
                        @include('livewire.frontend.navigation_mobile.events')
                        @include('livewire.frontend.navigation_mobile.courses')
                        @include('livewire.frontend.navigation_mobile.library')
                        @include('livewire.frontend.navigation_mobile.bookcases')
                        @include('livewire.frontend.navigation_mobile.association')
                        @include('livewire.frontend.navigation_mobile.profile')

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
                                    <i class="fa-solid fa-sign-out"></i>
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
