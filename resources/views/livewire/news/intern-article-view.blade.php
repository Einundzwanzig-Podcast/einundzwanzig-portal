<div class="bg-21gray flex flex-col h-screen justify-between">
    @googlefonts('article')
    {{-- HEADER --}}
    <livewire:frontend.header :country="null"/>
    <div class="bg-21gray font-article">
        <div class="relative mx-auto max-w-screen-2xl py-4 px-6 lg:px-8 overflow-hidden">
            <div class="absolute top-0 bottom-0 left-3/4 hidden w-screen bg-21gray lg:block"></div>
            <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
                <div>
                    <h2 class="text-lg font-semibold text-amber-600">{{ $libraryItem->tags->pluck('name')->join(', ') }}</h2>
                    <h3 class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-100 sm:text-4xl">{{ $libraryItem->name }}</h3>
                </div>
            </div>
            <div class="mx-auto max-w-prose text-base lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-8">
                <div class="mt-6 flex items-center">
                    <div class="flex-shrink-0">
                        <div>
                            <span class="sr-only text-gray-200">{{ $libraryItem->lecturer->name }}</span>
                            <img class="h-10 w-10 object-cover rounded"
                                 src="{{ $libraryItem->lecturer->getFirstMediaUrl('avatar') }}"
                                 alt="{{ $libraryItem->lecturer->name }}">
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-200">
                        <div class="text-gray-200">{{ $libraryItem->lecturer->name }}</div>
                        </p>
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
            <div class="mt-8 lg:grid lg:grid-cols-2 lg:gap-8">
                <div class="relative lg:col-start-2 lg:row-start-1">
                    <svg class="absolute top-0 right-0 -mt-20 -mr-20 hidden lg:block" width="404" height="384"
                         fill="none" viewBox="0 0 404 384" aria-hidden="true">
                        <defs>
                            <pattern id="de316486-4a29-4312-bdfc-fbce2132a2c1" x="0" y="0" width="20" height="20"
                                     patternUnits="userSpaceOnUse">
                                <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor"/>
                            </pattern>
                        </defs>
                        <rect width="404" height="384" fill="url(#de316486-4a29-4312-bdfc-fbce2132a2c1)"/>
                    </svg>
                    <div class="relative mx-auto max-w-prose text-base lg:max-w-none">
                        <figure>
                            <div class="aspect-w-12 aspect-h-7 lg:aspect-none">
                                <img class="rounded-lg object-cover object-center shadow-lg"
                                     src="{{ $libraryItem->getFirstMediaUrl('main') }}" alt="{{ $libraryItem->name }}"
                                     width="1184" height="1376">
                            </div>
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
                        </figure>
                    </div>
                </div>
                <div class="mt-8 lg:mt-0">
                    <div class="mx-auto max-w-prose text-base lg:max-w-none">
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
                                @else
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
                                        textToCopy: '{{ url()->route('article.view', ['libraryItem' => $libraryItem]) }}',
                                    }"
                                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                    lg black>
                                    <i class="fa fa-thin fa-copy mr-2"></i>
                                    {{ __('Share link') }}
                                </x-button>
                            @else
                                <x-button
                                    x-data="{
                                        textToCopy: '{{ url()->route('article.view', ['libraryItem' => $libraryItem]) }}',
                                    }"
                                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Share url copied!') }}',icon:'success'});"
                                    xs black>
                                    <i class="fa fa-thin fa-copy mr-2"></i>
                                    {{ __('Share link') }}
                                </x-button>
                            @endif
                        </div>

                        @if($libraryItem->type === 'youtube_video')
                            <div class="my-12">
                                <x-embed :url="$libraryItem->value"/>
                            </div>
                        @endif

                        @if($libraryItem->type === 'markdown_article')
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
                                                <time
                                                    datetime="2020-03-16">{{ number_format($libraryItem->sats, 0, ',', '.') }} {{ __('sats') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(!$invoice)
                                    <div class="mt-10 flex items-center justify-center gap-x-6">
                                        <div
                                            wire:click="pay"
                                            class="cursor-pointer rounded-md bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm hover:bg-gray-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white">
                                            <i class="fa-thin fa-bolt"></i>
                                            Pay with lightning
                                        </div>
                                        <div wire:click="$set('alreadyPaid', true)" class="cursor-pointer text-sm font-semibold leading-6 text-white">{{ __('already paid?') }} <span aria-hidden="true">→</span></div>
                                    </div>
                                @else
                                    <div class="mt-10 flex flex-col items-center justify-center gap-x-6 bg-white pb-12">
                                        <div class="text-sm font-semibold text-gray-900 py-6">
                                            {{ __('Click QR-Code to open your wallet') }}
                                        </div>
                                        <div class="flex justify-center" wire:key="qrcode">
                                            <a href="lightning:{{ $this->invoice }}">
                                                <img src="{{ 'data:image/png;base64, '. $this->qrCode }}" alt="qrcode">
                                            </a>
                                        </div>
                                    </div>
                                @endif
                                @if(!$invoice)
                                    <svg viewBox="0 0 1024 1024"
                                         class="absolute top-1/2 left-1/2 -z-10 h-[64rem] w-[64rem] -translate-x-1/2 [mask-image:radial-gradient(closest-side,white,transparent)]"
                                         aria-hidden="true">
                                        <circle cx="512" cy="512" r="512"
                                                fill="url(#827591b1-ce8c-4110-b064-7cb85a0b1217)" fill-opacity="0.7"/>
                                        <defs>
                                            <radialGradient id="827591b1-ce8c-4110-b064-7cb85a0b1217">
                                                <stop stop-color="#F7931A"/>
                                                <stop offset="1" stop-color="#F7931A"/>
                                            </radialGradient>
                                        </defs>
                                    </svg>
                                @endif
                                @if($alreadyPaid)
                                    <div class="flex items-center justify-center gap-x-6 py-2" wire:key="checkPaymentHashDiv">
                                        <div class="w-full flex flex-col space-y-2 justify-center" wire:key="paymentHash">
                                            <div class="w-full my-2 flex justify-center font-mono break-all py-2">
                                                <x-input.group :for="md5('checkThisPaymentHash')" :label="__('Payment Hash')">
                                                    <x-input autocomplete="off" wire:model.debounce="checkThisPaymentHash"
                                                             :placeholder="__('Payment Hash')"/>
                                                </x-input.group>
                                            </div>
                                        </div>
                                        @if($checkThisPaymentHash)
                                            <div wire:poll.keep-alive="checkPaymentHash" wire:key="checkPaymentHash"></div>
                                        @endif
                                    </div>
                                @endif
                                @if($invoice)
                                    <div class="flex items-center justify-center gap-x-6 bg-white py-2">
                                        <div
                                            x-data="{
                                                  textToCopy: '{{ $this->paymentHash }}',
                                                }"
                                            @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Payment hash copied!') }}',icon:'success'});" class="w-full flex flex-col space-y-2 justify-center" wire:key="paymentHash">
                                            <div class="w-full my-2 flex justify-center font-mono break-all px-6">
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
                                        </div>
                                        <div wire:poll.keep-alive="checkPaymentHash" wire:key="checkPaymentHash"></div>
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

                    <div wire:ignore>
                        <div class="flex flex-col sm:flex-row justify-center space-x-4 border-t border-white py-4 mt-4">
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
