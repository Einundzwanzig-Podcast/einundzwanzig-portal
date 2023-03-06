<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-4">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">
            <div
                wire:ignore
                class="w-full flex justify-center"
                x-data="{
                    init() {
                        let markers = {{ Js::from($allMarkers) }};

                        $('#mapworld').vectorMap({
                            zoomButtons : true,
                            zoomOnScroll: true,
                            map: 'world_mill',
                            backgroundColor: 'transparent',
                            markers: markers.map(function(h){ return {name: h.name, latLng: h.coords} }),
                            onMarkerClick: function(event, index) {
                                $wire.call('filterByMarker', markers[index].id)
                            },
                            markerStyle: {
                                initial: {
                                    image: '{{ asset('img/btc.png') }}',
                                }
                            },
                            regionStyle: {
                                initial: {
                                    fill: '#151515'
                                },
                                hover: {
                                    'fill-opacity': 1,
                                    cursor: 'default'
                                },
                            }
                        });
                    }
                }"
            >
                <div id="mapworld" style="width: 100%;" class="h-[200px] sm:h-[400px]"></div>
            </div>
        </div>
    </section>

    <div class="w-full pb-24">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <div class="md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-2xl font-bold leading-7 text-white sm:truncate sm:text-3xl sm:tracking-tight">
                        {{ __('Meetups') }}
                    </h2>
                </div>
                <div class="mt-4 flex md:mt-0 md:ml-4">
                    {{----}}
                </div>
            </div>
            <livewire:tables.meetup-table :country="$country->code"/>
        </div>
    </div>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>

    <div wire:ignore class="z-50">
        <script
            src="https://nostri.chat/public/bundle.js"
            data-website-owner-pubkey="daf83d92768b5d0005373f83e30d4203c0b747c170449e02fea611a0da125ee6"
            data-chat-type="GLOBAL"
            data-chat-tags="#einundzwanzig-portal-meetups-world"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="https://nostri.chat/public/bundle.css">
    </div>
</div>
