<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="bg-21gray py-24 sm:py-32">
        <div class="mx-auto grid max-w-7xl gap-y-20 gap-x-8 px-6 lg:px-8 xl:grid-cols-3">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold tracking-tight text-gray-200 sm:text-4xl">{{ __('News articles writer') }}</h2>
                <p class="mt-6 text-lg leading-8 text-gray-300">
                    {{ __('Click on any of the authors to see their articles.') }}
                </p>
            </div>
            <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-2 sm:gap-y-16 xl:col-span-2">

                @foreach($authors as $author)
                    <a href="{{ route('article.overview', ['filters' => ['author' => $author->slug]]) }}"
                       wire:key="author_{{ $author->id }}">
                        <li>
                            <div class="flex items-center gap-x-6">
                                <img class="h-16 w-16 rounded-full"
                                     src="{{ $author->getFirstMediaUrl('avatar') }}"
                                     alt="{{ $author->name }}">
                                <div>
                                    <h3 class="text-base font-semibold leading-7 tracking-tight text-gray-200">
                                        {{ $author->name }}
                                    </h3>
                                    <p class="text-sm font-semibold leading-6 text-amber-600">
                                        {{ $author->library_items_count }} {{ __('articles') }}
                                    </p>
                                </div>
                            </div>
                        </li>
                    </a>
                @endforeach

            </ul>
        </div>
    </div>

    <div wire:ignore class="z-50 hidden md:block">
        <script
            src="{{ asset('dist/einundzwanzig.chat.js') }}"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig_portal_news_authors"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
    </div>
</div>
