<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    <div class="max-w-screen-2xl mx-auto">
        <div class="w-full mb-6 sm:my-6">
            <x-input class="sm:min-w-[900px]" placeholder="Suche..." wire:model.debounce="search">
                <x-slot name="append">
                    <div class="absolute inset-y-0 right-0 flex items-center p-0.5">
                        <x-button
                            wire:click="resetFiltering()"
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
                <div class="md:flex md:items-center md:justify-between py-6">
                    <h3 class="text-2xl font-medium leading-6 text-gray-200">{{ __('Podcast Episodes') }}</h3>
                    <x-button wire:click="resetFiltering()"
                              xs>
                        {{ __('Reset filtering and search') }}
                    </x-button>
                </div>
            </div>

            <div class="my-12">

                <div wire:loading.class="opacity-25"
                     class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">

                    @foreach($episodes as $episode)
                        <div wire:key="episode_{{ $episode->id }}"
                             class="flex flex-col overflow-hidden rounded-lg  border-2 border-[#F7931A]">
                            <div class="flex-shrink-0 pt-6">
                                <a href="{{ $episode->data['link'] }}" target="_blank">
                                    <img class="h-48 w-full object-contain"
                                         src="{{ !empty($episode->data['image']) ? $episode->data['image'] : $episode->podcast->data['image'] }}"
                                         alt="{{ $episode->data['title'] }}">
                                </a>
                            </div>
                            <div class="flex flex-1 flex-col justify-between bg-21gray p-6">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-amber-600">
                                    <div
                                        class="text-amber-500">{{ __('Language') }}: {{ $episode->data['feedLanguage'] }}</div>
                                    </div>
                                    <a href="{{ $episode->data['link'] }}" target="_blank"
                                       class="mt-2 block">
                                        <p class="text-xl font-semibold text-gray-200">{{ $episode->data['title'] }}</p>
                                        <p class="prose mt-3 text-base text-gray-300 line-clamp-3">{{ strip_tags($episode->data['description']) }}</p>
                                    </a>
                                </div>
                                <div class="mt-6 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div>
                                            <span
                                                class="sr-only text-gray-200">{{ $episode->podcast->title }}</span>
                                            <img class="h-10 w-10 object-cover rounded"
                                                 src="{{ $episode->podcast->data['image'] }}"
                                                 alt="{{ $episode->podcast->data['title'] }}">
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-200">
                                            <div class="text-gray-200">{{ $episode->podcast->title }}</div>
                                        </div>
                                        <div class="flex space-x-1 text-sm text-gray-400">
                                            <time
                                                datetime="2020-03-16">{{ \App\Support\Carbon::parse($episode->data['datePublished'])->asDateTime() }}</time>
                                                <span aria-hidden="true">&middot;</span>
                                                <span>{{ round($episode->data['duration'] / 60) }} {{ __('minutes') }}</span>
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

                    @if($episodes->hasMorePages())
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
            src="https://nostri.chat/public/bundle.js"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig_portal_podcasts"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="https://nostri.chat/public/bundle.css">
    </div>
</div>
