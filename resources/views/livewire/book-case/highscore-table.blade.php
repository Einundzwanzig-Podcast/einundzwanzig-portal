<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <div class="flex items-start">
                <div class="w-1/2">
                    <h1 class="mb-6 text-5xl font-extrabold leading-none max-w-5xl mx-auto tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                        Orange-Pill <span
                            class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">{{ __('Highscore Table') }}</span>
                    </h1>
                    <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl">
                        {{ __('Hall of fame of our honorable plebs') }}
                    </p>
                </div>
            </div>

            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                @foreach($plebs as $pleb)
                    <li
                        wire:click="openModal({{ $pleb->id }})"
                        class="cursor-pointer col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-amber-500 text-center shadow-2xl">
                        <div class="flex flex-1 flex-col p-8">
                            <img class="mx-auto h-32 w-32 object-cover flex-shrink-0 rounded-full"
                                 src="{{ $pleb->profile_photo_url }}" alt="{{ $pleb->name }}">
                            <h3 class="mt-6 text-sm font-medium text-gray-900 truncate">{{ $pleb->name }}</h3>
                            <dl class="mt-1 flex flex-grow flex-col justify-between">
                                <dd class="text-sm text-gray-800">{{ $pleb->orange_pills_count }} {{ __('Bookcases') }} {{ __('Orange pilled') }}</dd>
                                <dd class="mt-3">
                                    <span class="rounded-full bg-21gray px-2 py-1 text-xs font-medium text-gray-200">{{ __('Points') }}: {{ $pleb->getPoints() }}</span>
                                </dd>
                            </dl>
                        </div>
                        {{--<div>
                            <div class="-mt-px flex divide-x divide-gray-200">
                                <div class="flex w-0 flex-1">
                                    <a href="mailto:janecooper@example.com" class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                                        <!-- Heroicon name: mini/envelope -->
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.25 1.25 0 001.118 0L19 7.162V6a2 2 0 00-2-2H3z" />
                                            <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                                        </svg>
                                        <span class="ml-3">Email</span>
                                    </a>
                                </div>
                                <div class="-ml-px flex w-0 flex-1">
                                    <a href="tel:+1-202-555-0170" class="relative inline-flex w-0 flex-1 items-center justify-center rounded-br-lg border border-transparent py-4 text-sm font-medium text-gray-700 hover:text-gray-500">
                                        <!-- Heroicon name: mini/phone -->
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M2 3.5A1.5 1.5 0 013.5 2h1.148a1.5 1.5 0 011.465 1.175l.716 3.223a1.5 1.5 0 01-1.052 1.767l-.933.267c-.41.117-.643.555-.48.95a11.542 11.542 0 006.254 6.254c.395.163.833-.07.95-.48l.267-.933a1.5 1.5 0 011.767-1.052l3.223.716A1.5 1.5 0 0118 15.352V16.5a1.5 1.5 0 01-1.5 1.5H15c-1.149 0-2.263-.15-3.326-.43A13.022 13.022 0 012.43 8.326 13.019 13.019 0 012 5V3.5z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-3">Call</span>
                                    </a>
                                </div>
                            </div>
                        </div>--}}
                    </li>
                @endforeach


            </ul>

            <x-jet-dialog-modal wire:model="viewingModal" maxWidth="screen" bg="bg-21gray">
                <x-slot name="title">
                    @if($modal)
                        <div class="text-gray-200">
                            {{ $modal->name }}
                        </div>
                    @endif
                </x-slot>

                <x-slot name="content">
                    @if($modal)
                        <div class="space-y-4 mt-16 flex flex-col justify-center min-h-[600px]">

                            <div>
                                <div class="mt-6 flow-root">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">
                                        <li class="py-5">
                                            <div class="relative focus-within:ring-2 focus-within:ring-indigo-500">
                                                <h3 class="text-sm font-semibold text-gray-200">
                                                    <div class="">
                                                        <!-- Extend touch target to entire panel -->
                                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                                        {{ $modal->name }} {{ __('has') }} {{ $modal->reputations->where('name', 'LoggedIn')->sum('point') }} {{ __('logins') }}
                                                    </div>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-200 line-clamp-2">{{ __('You get a point when you log in.') }}</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <ul role="list"
                                class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
                                @foreach($modal->orangePills as $orangePill)
                                    <li class="relative">
                                        <div
                                            class="group aspect-w-10 aspect-h-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                            <img
                                                src="{{ $orangePill->bookCase->getFirstMediaUrl('images') ? $orangePill->bookCase->getFirstMediaUrl('images') : asset('img/empty_book_case.webp') }}"
                                                alt="book_case"
                                                class="pointer-events-none object-cover group-hover:opacity-75">
                                        </div>
                                        <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-200">
                                            210 {{ __('points') }}</p>
                                        <p class="pointer-events-none block text-sm font-medium text-gray-200">{{ $orangePill->date->asDate() }}</p>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                    @endif
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="resetModal" wire:loading.attr="disabled">
                        @lang('Close')
                    </x-jet-secondary-button>
                </x-slot>
            </x-jet-dialog-modal>

        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
