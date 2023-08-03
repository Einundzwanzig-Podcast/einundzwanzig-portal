<div class="grid min-h-full grid-cols-1 grid-rows-[1fr,auto,1fr] bg-white lg:grid-cols-[max(50%,36rem),1fr]">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.css"
          integrity="sha512-fSKum0u74TzF+eAXxBS0oIp3LlON1gd++1rifA0ZnQWKP2JXbCdomS2k0BDEM7v0se7mQOpOwedRw/lRsSPAaA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <header class="mx-auto w-full max-w-7xl px-6 pt-6 sm:pt-10 lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:px-8">
        <a href="/">
            <span class="sr-only">Bitcoin Team 218 </span>
            <img class="h-10 w-auto sm:h-12" src="{{ asset('img/bsc/logo.jpg') }}"
                 alt="logo">
        </a>
    </header>
    <main class="mx-auto w-full max-w-7xl px-6 py-4 sm:py-4 lg:col-span-2 lg:col-start-1 lg:row-start-2 lg:px-8">
        <div class="max-w-lg">
            <p class="text-base font-semibold leading-8 text-indigo-600">Start am 17.06.2023 09:30 Uhr</p>
            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Baltic Sea Circle Rally
                Bitcoin Team 218</h1>
            <p class="mt-6 text-base leading-7 text-gray-600">Besucht das Bitcoin Team 218 von Daktari und
                Cercatrova.</p>
            <p class="mt-6 text-base leading-7 text-gray-600">Gut Barsthorst, Hamburg</p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                <x-button primary lg href="https://t.me/rallyejukebox"
                          target="_blank">
                    <i class="fa-solid fa-music"></i>
                    Musik Jukebox
                </x-button>
            </p>
            <p class="mt-6 text-base leading-7 text-gray-600">
                <x-button primary lg href="https://findpenguins.com/superlative-adventure-club/live?rallye=2023-bsc"
                          target="_blank">
                    <i class="fa-solid fa-map"></i>
                    Tracking
                </x-button>
            </p>
            <div class="mt-6">
                <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">⚡ Lightning Hupe</h1>
                <a href="lightning:LNURL1DP68GURN8GHJ7MRWVF5HGUEWV4EX26T8DE5HX6R0WF5H5MMWWSH8S7T69AKXUATJD3JX2ANFVDJJ7CTSDYHHVV30D3H82UNV9AZ5ZAZ9FEVKVNZSV3PYZEZRW3SK2WTHVF2KZ0MSD9HR6VFJYESK6MM4DE6R6VPW8QNXGATJV96XJMMW85ERZV332Q48N4">
                    <img src="{{ asset('img/bsc/qr.png') }}" alt="qr">
                </a>
                <p class="text-xs">
                    Proof Of Honk - LN Fanfare Team 218
                </p>
            </div>
        </div>
    </main>
    <div id="me" class="hidden lg:relative lg:col-start-2 lg:row-start-1 lg:row-end-4 lg:block">
        <div></div>
    </div>
    <script>
        document.addEventListener(
            'livewire:load',
            function () {
                $('#me')
                    .vegas({
                        delay:                   10000,
                        timer:                   true,
                        shuffle:                 false,
                        firstTransition:         'blur',
                        firstTransitionDuration: 5000,
                        transition:              'blur',
                        transitionDuration:      2000,
                        slides:                  [
                            { src: '/img/bsc/1.jpg' },
                            { src: '/img/bsc/2.jpg' },
                            { src: '/img/bsc/3.jpg' },
                            { src: '/img/bsc/4.jpg' }
                        ]
                    })
            }
        )
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vegas/2.5.4/vegas.min.js"
            integrity="sha512-lYAcY5E6LZVeNB3Pky37SxbYKzo8A68MzKFoPg5oTuolhRm36D+YRvkrAQS4JuKsaGYeJ5KA5taMEtpNlPUeOA=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @push('modals')
        <div wire:ignore class="z-50 hidden md:block">
            <script
                src="{{ asset('dist/einundzwanzig.chat.js') }}"
                data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
                data-chat-type="GLOBAL"
                data-chat-tags="#einundzwanzig_portal_bsc }}"
                data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
            ></script>
            <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
        </div>
    @endpush
</div>
