<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    <div class="max-w-screen-2xl mx-auto">
        <div class="w-full mb-6 sm:my-6">
            <div class="flex w-full justify-center mb-4">
                <x-button primary :href="route('library.libraryItem.form', ['country' => $country])">
                    <i class="fa-thin fa-plus"></i>
                    {{ __('Submit contents') }}
                </x-button>
            </div>
            <x-input class="sm:min-w-[900px]" placeholder="Suche..." wire:model.debounce="search">
                <x-slot name="append">
                    <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                        <x-button
                            wire:click="resetFiltering({{ $isLecturerPage }})"
                            class="h-full rounded-r-md"
                            black
                            flat
                            squared
                        >
                            <i class="fa-thin fa-xmark"></i>
                        </x-button>
                    </div>
                </x-slot>
            </x-input>
        </div>
    </div>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10" id="table">

            <div class="relative border-b border-gray-200 pb-5 sm:pb-0">
                <div class="md:flex md:items-center md:justify-between">
                    @if(request()->route()->getName() === 'library.table.lecturer')
                        <h3 class="text-2xl font-medium leading-6 text-gray-200">{{ __('Lecturer Libraries') }}</h3>
                    @else
                        <h3 class="text-2xl font-medium leading-6 text-gray-200">{{ __('Libraries') }}</h3>
                    @endif
                    <x-button wire:click="resetFiltering({{ $isLecturerPage }})"
                              xs>{{ __('Reset filtering and search') }}</x-button>
                </div>
                <div class="mt-4">
                    <!-- Dropdown menu on small screens -->
                    {{--<div class="sm:hidden">
                        <label for="current-tab" class="sr-only">Select a tab</label>
                        <select id="current-tab" name="current-tab" class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-amber-500 focus:outline-none focus:ring-amber-500 sm:text-sm">
                            <option>Applied</option>
                            <option>Phone Screening</option>
                            <option>Interview</option>
                            <option>Offer</option>
                            <option>Hired</option>
                        </select>
                    </div>--}}
                    <!-- Tabs at small breakpoint and up -->
                    <div class="hidden sm:block">
                        <nav class="-mb-px flex space-x-8">
                            @foreach($libraries as $library)
                                @php
                                    $currentLibraryClass = $currentTab === $library['name'] ? 'border-amber-500 text-amber-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300';
                                @endphp
                                @if($isLecturerPage)
                                    <a href="{{ route('library.table.lecturer', ['country' => $country, 'currentTab' => $library['name']]) }}"
                                       class="{{ $currentLibraryClass }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ $library['name'] }}</a>
                                @else
                                    <a href="{{ route('library.table.libraryItems', ['country' => $country, 'currentTab' => $library['name']]) }}"
                                       class="{{ $currentLibraryClass }} whitespace-nowrap pb-4 px-1 border-b-2 font-medium text-sm">{{ $library['name'] }}</a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>

            <livewire:library.search-by-tag-component/>
            <div class="my-12">

                <div wire:loading.class="opacity-25"
                     class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">

                    @foreach($libraryItems as $libraryItem)
                        @php
                            $link = $isLecturerPage ? route('lecturerMaterial.view', ['libraryItem' => $libraryItem]) : route('libraryItem.view', ['libraryItem' => $libraryItem]);
                        @endphp
                        <div wire:key="library_item_{{ $libraryItem->id }}"
                             class="flex flex-col overflow-hidden rounded-lg  border-2 border-[#F7931A]">
                            <div class="flex-shrink-0 pt-6">
                                <a href="{{ $link }}">
                                    <img class="h-48 w-full object-contain"
                                         src="{{ $libraryItem->getFirstMediaUrl('main') }}"
                                         alt="{{ $libraryItem->name }}">
                                </a>
                            </div>
                            <div class="flex flex-1 flex-col justify-between bg-21gray p-6">
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-amber-600">
                                    <div
                                        class="text-amber-500">{{ $libraryItem->tags->pluck('name')->join(', ') }}</div>
                                    </p>
                                    <a href="{{ $link }}"
                                       class="mt-2 block">
                                        <p class="text-xl font-semibold text-gray-200">{{ $libraryItem->name }}</p>
                                        <p class="mt-3 text-base text-gray-300 line-clamp-6">{{ strip_tags($libraryItem->excerpt) }}</p>
                                    </a>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div>
                                            <span
                                                class="sr-only text-gray-200">{{ $libraryItem->lecturer->name }}</span>
                                            <img class="h-10 w-10 object-cover rounded"
                                                 src="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                                 alt="{{ $libraryItem->lecturer->name }}">
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-200">
                                            <div class="text-gray-200">{{ $libraryItem->lecturer->name }}</div>
                                        </div>
                                        <div class="flex space-x-1 text-sm text-gray-400">
                                            <time
                                                datetime="2020-03-16">{{ $libraryItem->created_at->asDateTime() }}</time>
                                            @if($libraryItem->read_time)
                                                <span aria-hidden="true">&middot;</span>
                                                <span>{{ $libraryItem->read_time }} {{ __('min read') }}</span>
                                            @endif
                                        </div>
                                        <div
                                            class="flex space-x-1 text-sm text-gray-500 justify-end items-end">
                                            <div>
                                                <x-button xs
                                                          :href="route('library.libraryItem.form', ['country' => $country, 'libraryItem' => $libraryItem])">
                                                    <i class="fa fa-thin fa-edit"></i>
                                                    {{ __('Edit') }}
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div
                        x-data="{
                                observe () {
                                    let observer = new IntersectionObserver((entries) => {
                                        entries.forEach(entry => {
                                            if (entry.isIntersecting) {
                                                @this.call('loadMore')
                                            }
                                        })
                                    }, {
                                        root: null
                                    })
                                    observer.observe(this.$el)
                                }
                            }"
                        x-init="observe"
                    ></div>

                    @if($libraryItems->hasMorePages())
                        <x-button outline wire:click.prevent="loadMore">{{ __('load more...') }}</x-button>
                    @endif

                </div>

            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>

    <div wire:ignore class="z-50">
        <script
            src="{{ asset('dist/einundzwanzig.chat.js') }}"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig_portal_library"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
    </div>
</div>
