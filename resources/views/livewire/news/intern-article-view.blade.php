<div class="bg-21gray flex flex-col h-screen justify-between">
    @googlefonts('article')
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>

    <div class="lg:h-[985px] lg:overflow-y-auto">
        <div
            class="font-article overflow-hidden relative isolate bg-21gray px-6 py-24 sm:py-32 lg:overflow-visible lg:px-0">
            <div class="absolute inset-0 -z-10 opacity-10 overflow-hidden">
                <svg
                    class="absolute top-0 left-[max(50%,25rem)] h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]"
                    aria-hidden="true">
                    <defs>
                        <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1"
                                 patternUnits="userSpaceOnUse">
                            <path d="M100 200V.5M.5 .5H200" fill="none"/>
                        </pattern>
                    </defs>
                    <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                        <path
                            d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z"
                            stroke-width="0"/>
                    </svg>
                    <rect width="100%" height="100%" stroke-width="0"
                          fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)"/>
                </svg>
            </div>
            <div
                class="mx-auto grid max-w-screen-2xl grid-cols-1 gap-y-16 gap-x-8 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
                <div
                    class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                    <div class="lg:pr-4">
                        <div>
                            <h2 class="text-lg font-semibold text-amber-600">{{ $libraryItem->tags->pluck('name')->join(', ') }}</h2>
                            <h3 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-100 sm:text-4xl">{{ $libraryItem->name }}</h3>
                        </div>
                        <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
                            <div class="mt-6 flex items-center w-full">
                                <div class="flex-shrink-0">
                                    <div>
                                        <span class="sr-only text-gray-200">{{ $libraryItem->lecturer->name }}</span>
                                        <img class="h-10 w-10 object-cover rounded"
                                             src="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                             alt="{{ $libraryItem->lecturer->name }}">
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-200">
                                        <div class="text-gray-200">{{ $libraryItem->lecturer->name }}</div>
                                    </div>
                                    <div class="flex space-x-1 text-sm text-gray-500">
                                        <time datetime="2020-03-16">{{ $libraryItem->created_at->asDateTime() }}</time>
                                        @if($libraryItem->read_time)
                                            <span aria-hidden="true">&middot;</span>
                                            <span>{{ $libraryItem->read_time }} {{ __('min read') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="-mt-12 -ml-12 p-12 lg:sticky lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden">
                    <img
                        class="w-[48rem] max-w-full rounded-xl bg-gray-900 shadow-xl ring-1 ring-gray-400/10 sm:w-[57rem]"
                        src="{{ $libraryItem->getFirstMediaUrl('main') }}" alt="{{ $libraryItem->name }}">
                    <figcaption class="mt-3 flex text-sm text-gray-200">
                        <!-- Heroicon name: mini/camera -->
                        <svg class="h-5 w-5 flex-none text-gray-400" xmlns="http://www.w3.org/2000/svg"
                             viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M1 8a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 018.07 3h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0016.07 6H17a2 2 0 012 2v7a2 2 0 01-2 2H3a2 2 0 01-2-2V8zm13.5 3a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM10 14a3 3 0 100-6 3 3 0 000 6z"
                                  clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-2">{{ $libraryItem->main_image_caption ?? $libraryItem->name }}</span>
                    </figcaption>
                </div>
                <div
                    class="lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                    <div class="lg:pr-4">
                        <div class="max-w-xl text-base leading-7 text-gray-700 lg:max-w-xl">

                            <div class="mx-auto text-base lg:max-w-none">
                                <div class="prose md:prose-lg prose-invert">
                                    <x-markdown class="leading-normal">
                                        {!! $libraryItem->subtitle !!}
                                    </x-markdown>
                                </div>
                            </div>
                            <div
                                class="prose md:prose-lg prose-invert mx-auto mt-5 text-gray-100 lg:col-start-1 lg:row-start-1 lg:max-w-none">
                                <div class="flex flex-col space-y-1">
                                    @if($libraryItem->type !== 'markdown_article' && str($libraryItem->value)->contains('http'))
                                        @if($libraryItem->type === 'youtube_video')
                                            <x-button lg amber :href="$libraryItem->value" target="_blank">
                                                <i class="fa fa-brand fa-youtube mr-2"></i>
                                                {{ __('Open on Youtube') }}
                                            </x-button>
                                        @elseif($libraryItem->type !== 'markdown_article' && $libraryItem->type !== 'markdown_article_extern')
                                            <x-button lg amber :href="$libraryItem->value" target="_blank">
                                                <i class="fa fa-thin fa-book-open mr-2"></i>
                                                {{ __('Open') }}
                                            </x-button>
                                        @endif
                                    @endif
                                    @if($libraryItem->type === 'downloadable_file')
                                        <x-button lg amber :href="$libraryItem->getFirstMediaUrl('single_file')"
                                                  target="_blank">
                                            <i class="fa fa-thin fa-download mr-2"></i>
                                            {{ __('Download') }}
                                        </x-button>
                                    @endif
                                    @if($libraryItem->type === 'podcast_episode')
                                        <x-button lg amber :href="$libraryItem->episode->data['link']" target="_blank">
                                            <i class="fa fa-thin fa-headphones mr-2"></i>
                                            {{ __('Listen') }}
                                        </x-button>
                                    @endif
                                    @if($libraryItem->type !== 'markdown_article')
                                        <x-button
                                            x-data="{
                                                textToCopy: '{{ url()->route('libraryItem.view', ['libraryItem' => $libraryItem]) }}',
                                            }"
                                            @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                            lg black>
                                            <i class="fa fa-thin fa-copy mr-2"></i>
                                            {{ __('Share link') }}
                                        </x-button>
                                    @elseif($libraryItem->news)
                                        <x-button
                                            x-data="{
                                                textToCopy: '{{ url()->route('article.view', ['libraryItem' => $libraryItem]) }}',
                                            }"
                                            @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                            xs black>
                                            <i class="fa fa-thin fa-copy mr-2"></i>
                                            {{ __('Share link') }}
                                        </x-button>
                                    @else
                                    @endif
                                </div>

                                @if($libraryItem->type === 'youtube_video')
                                    <div class="my-12">
                                        <x-embed :url="$libraryItem->value"/>
                                    </div>
                                @endif

                                @if($libraryItem->type === 'markdown_article' || $libraryItem->type === 'markdown_article_extern')
                                    <x-markdown class="leading-normal">
                                        {!! $libraryItem->value !!}
                                    </x-markdown>
                                @endif
                            </div>

                            @if($libraryItem->sats && !$invoicePaid)
                                <div
                                    class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                                    <div
                                        class="relative isolate overflow-hidden bg-gray-900 px-6 py-12 text-center shadow-2xl sm:rounded-3xl sm:px-16">
                                        <h2 class="mx-auto max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl">
                                            {{ __('You can read the full article if you paid with Lightning') }}
                                        </h2>
                                        <div
                                            class="flex max-w-2xl text-3xl font-bold tracking-tight text-white sm:text-4xl justify-center items-center">
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
                                                        <div class="text-gray-200">{{ __('Receiver') }}
                                                            : {{ $libraryItem->lecturer->name }}</div>
                                                    </div>
                                                    <div class="flex space-x-1 text-sm text-gray-300">
                                                        <time>{{ number_format($libraryItem->sats, 0, ',', '.') }} {{ __('sats') }}</time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @if(!$invoice)
                                            <div class="mt-10 flex items-center justify-center gap-x-6">
                                                <x-button
                                                    wire.loading.attr="disabled"
                                                    primary
                                                    wire:click="pay">
                                                    <i class="fa-thin fa-bolt"></i>
                                                    Pay with lightning
                                                </x-button>
                                                <div wire:click="$set('alreadyPaid', true)"
                                                     class="cursor-pointer text-sm font-semibold leading-6 text-white">{{ __('already paid?') }}
                                                    <span aria-hidden="true">→</span></div>
                                            </div>
                                        @else
                                            <div
                                                class="mt-10 flex flex-col items-center justify-center gap-x-6 bg-white pb-12">
                                                <div class="text-sm font-semibold text-gray-900 py-6">
                                                    {{ __('Click QR-Code to open your wallet') }}
                                                </div>
                                                <div class="flex justify-center" wire:key="qrcode">
                                                    <a href="lightning:{{ $this->invoice }}">
                                                        <img src="{{ 'data:image/png;base64, '. $this->qrCode }}"
                                                             alt="qrcode">
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                        @if(!$invoice)
                                            <svg viewBox="0 0 1024 1024"
                                                 class="absolute top-1/2 left-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                                                 aria-hidden="true">
                                                <circle cx="512" cy="512" r="512"
                                                        fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)"
                                                        fill-opacity="0.7"/>
                                                <defs>
                                                    <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                                                        <stop stop-color="#F7931A"/>
                                                        <stop offset="1" stop-color="#F7931A"/>
                                                    </radialGradient>
                                                </defs>
                                            </svg>
                                        @endif
                                        @if($alreadyPaid)
                                            <div class="flex items-center justify-center gap-x-6 py-2"
                                                 wire:key="checkPaymentHashDiv">
                                                <div class="w-full flex flex-col space-y-2 justify-center"
                                                     wire:key="paymentHash">
                                                    <div
                                                        class="w-full my-2 flex justify-center font-mono break-all py-2">
                                                        <x-input.group :for="md5('checkThisPaymentHash')"
                                                                       :label="__('Payment Hash')">
                                                            <x-input autocomplete="off"
                                                                     wire:model.debounce="checkThisPaymentHash"
                                                                     :placeholder="__('Payment Hash')"/>
                                                        </x-input.group>
                                                    </div>
                                                </div>
                                                @if($checkThisPaymentHash)
                                                    <div wire:poll.keep-alive="checkPaymentHash"
                                                         wire:key="checkPaymentHash"></div>
                                                @endif
                                            </div>
                                        @endif
                                        @if($invoice)
                                            <div class="flex items-center justify-center gap-x-6 bg-white py-2">
                                                <div
                                                    x-data="{
                                                  textToCopy: '{{ $this->paymentHash }}',
                                                }"
                                                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Payment hash copied!') }}',icon:'success'});"
                                                    class="w-full flex flex-col space-y-2 justify-center"
                                                    wire:key="paymentHash">
                                                    <div
                                                        class="w-full my-2 flex justify-center font-mono break-all px-6">
                                                        <input class="w-full" readonly wire:key="paymentHashInput"
                                                               onClick="this.select();"
                                                               value="{{ $this->paymentHash }}"/>
                                                    </div>
                                                    <div
                                                    >
                                                        <x-button
                                                            black
                                                        >
                                                            <i class="fa fa-thin fa-clipboard"></i>
                                                            {{ __('Copy payment hash') }}
                                                        </x-button>
                                                    </div>
                                                    <div
                                                        class="w-full my-2 flex justify-center font-mono font-bold p-4">
                                                        <p class="text-amber-500">{{ __('As a guest, please save your payment hash so that you can unlock this article later. Unfortunately, we cannot save your purchase status permanently for guests. Please log in to use this feature.') }}</p>
                                                    </div>
                                                </div>
                                                <div wire:poll.keep-alive="checkPaymentHash"
                                                     wire:key="checkPaymentHash"></div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div
                                    class="prose md:prose-lg prose-invert mx-auto mt-5 text-gray-100 lg:col-start-1 lg:row-start-1 lg:max-w-none">
                                    <x-markdown class="leading-normal">
                                        {!! $libraryItem->value_to_be_paid !!}
                                    </x-markdown>

                                </div>
                            @endif

                            @if($payNymQrCode)
                                <div
                                    class="flex flex-col sm:flex-row justify-center space-x-4 border-t border-white py-4 mt-4">
                                    <h1 class="text-2xl text-gray-200">PayNym</h1>
                                    <div class="p-12 bg-white">
                                        <img src="{{ 'data:image/png;base64, '. $payNymQrCode }}" alt="qrcode">
                                    </div>
                                </div>
                            @endif

                            <div wire:ignore>
                                <div
                                    class="flex flex-col sm:flex-row justify-center space-x-4 border-t border-white py-4 mt-4">
                                    @if($libraryItem->lecturer->lightning_address || $libraryItem->lecturer->lnurl || $libraryItem->lecturer->node_id)
                                        <h1 class="text-2xl text-gray-200">value-4-value</h1>
                                        <div wire:ignore>
                                            <lightning-widget
                                                name="{{ $libraryItem->lecturer->name }}"
                                                accent="#f7931a"
                                                to="{{ $libraryItem->lecturer->lightning_address ?? $libraryItem->lecturer->lnurl ?? $libraryItem->lecturer->node_id }}"
                                                image="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                                amounts="21,210,2100,21000"
                                            />
                                        </div>
                                    @endif
                                </div>

                                <script src="https://embed.twentyuno.net/js/app.js"></script>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FOOTER --}}
    <livewire:frontend.footer/>

    <div x-data="{paid: @entangle('invoicePaid')}" x-init="$watch('paid', value => {if (value) {
        party.confetti(document.body, {
            count: party.variation.range(20, 40),
        });
    }})"></div>

    <div wire:ignore class="z-50">
        <script src="https://cdn.jsdelivr.net/npm/party-js@latest/bundle/party.min.js"></script>
        <script
            src="{{ asset('dist/einundzwanzig.chat.js') }}"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig_portal_{{ str($libraryItem->slug)->replace('-', '_') }}"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
    </div>
</div>
