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
                    <li x-data="{show: false}"
                        wire:key="pleb_{{ $pleb->id }}"
                        class="cursor-pointer col-span-1 flex flex-col rounded-lg bg-amber-500 text-center shadow-2xl">
                        <div>
                            <div class="-mt-px flex ">
                                <div class="flex w-0 flex-1">
                                    @if($pleb->lightning_address || $pleb->lnurl || $pleb->node_id)
                                        <div x-on:click="show = !show"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="transition ease-in duration-300"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0 scale-90"
                                             class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-xl font-bold text-gray-800 hover:text-gray-900">
                                            <i class="fa-thin fa-bolt-lightning"></i>
                                            <span class="ml-3" x-text="show ? 'Schließen' : 'Donate'"></span>
                                        </div>
                                    @else
                                        <a href="{{ route('profile.show') }}"
                                           class="relative -mr-px inline-flex w-0 flex-1 items-center justify-center rounded-bl-lg border border-transparent py-4 text-xl font-bold text-gray-800 hover:text-gray-900">
                                            <i class="fa-thin fa-bolt-slash"></i>
                                            <span class="ml-3">{{ __('Missing lightning address') }}</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div x-show="show">
                                @if($pleb->lightning_address || $pleb->lnurl || $pleb->node_id)
                                    <div wire:ignore>
                                        <lightning-widget
                                            name="{{ $pleb->name }}"
                                            accent="#f7931a"
                                            to="{{ $pleb->lightning_address ?? $pleb->lnurl ?? $pleb->node_id }}"
                                            image="{{ $pleb->profile_photo_url }}"
                                            amounts="21,210,2100,21000"
                                        />
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-1 flex-col p-8" x-show="!show"
                             wire:click="openModal({{ $pleb->id }})">
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
                    </li>
                @endforeach
                <script src="https://embed.twentyuno.net/js/app.js"></script>

            </ul>

            <style>
                .card {
                    border-radius: 0px !important;
                }
            </style>

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

                            <div class="bg-amber-800 p-4 rounded">
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
                                        <a target="_blank"
                                           href="{{ route('bookCases.comment.bookcase', ['country' => $country, 'bookCase' => $orangePill->bookCase]) }}">
                                            <div
                                                class="group aspect-w-10 aspect-h-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                                                <img
                                                    src="{{ $orangePill->getFirstMediaUrl('images') ? $orangePill->getFirstMediaUrl('images') : ($orangePill->bookCase->getFirstMediaUrl('images') ? $orangePill->bookCase->getFirstMediaUrl('images') : asset('img/empty_book_case.webp')) }}"
                                                    alt="book_case"
                                                    class="pointer-events-none object-cover group-hover:opacity-75">
                                            </div>
                                            <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-200">
                                                210 {{ __('points') }}</p>
                                            <p class="pointer-events-none block text-sm font-medium text-gray-200">{{ $orangePill->date->asDate() }}</p>
                                            <p class="pointer-events-none block text-sm font-medium text-gray-200">{{ $orangePill->bookCase->title }}</p>
                                            <p class="pointer-events-none block text-sm font-medium text-gray-200">{{ $orangePill->bookCase->address }}</p>
                                        </a>
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
