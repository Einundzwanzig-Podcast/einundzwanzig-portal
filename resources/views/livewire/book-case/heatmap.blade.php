<div
    id="matrix"
    class="h-screen justify-between relative">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country" bgColor="bg-transparent"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10">

            <h1 class="text-xl font-bold py-4 text-gray-200">
                {{ __('Orange Pill Heatmap') }}
            </h1>

            <div
                x-data="{
                    data: @js($heatmap_data),
                    init() {
                        var testData = {
                          max: 8,
                          data: this.data,
                        };

                        var baseLayer = L.tileLayer(
                            'https://stamen-tiles-{s}.a.ssl.fastly.net/toner/{z}/{x}/{y}.png',{
                                attribution: 'Map tiles by <a href=\'http://stamen.com\'>Stamen Design</a>, <a href=\'http://creativecommons.org/licenses/by/3.0\'>CC BY 3.0</a> &mdash; Map data &copy; <a href=\'http://www.openstreetmap.org/copyright\'>OpenStreetMap</a>',
                                maxZoom: 8
                            }
                        );

                        var cfg = {
                            'radius': 25,
                            'maxOpacity': .6,
                            // scales the radius based on map zoom
                            'scaleRadius': false,
                            // if set to false the heatmap uses the global maximum for colorization
                            // if activated: uses the data maximum within the current map boundaries
                            //   (there will always be a red spot with useLocalExtremas true)
                            'useLocalExtrema': true,
                            // which field name in your data represents the latitude - default 'lat'
                            latField: 'lat',
                            // which field name in your data represents the longitude - default 'lng'
                            lngField: 'lng',
                            // which field name in your data represents the data value - default 'value'
                            valueField: 'count'
                        };

                        var heatmapLayer = new HeatmapOverlay(cfg);

                        var map = new L.Map($refs.map, {
                            center: new L.LatLng(51.1642,10.4541194),
                            zoom: 6,
                            maxZoom: 8,
                            layers: [baseLayer, heatmapLayer]
                        });

                        heatmapLayer.setData(testData);
                    }
                }"
            >
                <div x-ref="map" style="height: 70vh;"></div>
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
            data-chat-tags="#einundzwanzig-bookcases"
            data-relays="wss://nostr.einundzwanzig.space,wss://nostr.easify.de,wss://nostr.mom,wss://relay.damus.io,wss://relay.snort.social"
        ></script>
        <link rel="stylesheet" href="{{ asset('dist/einundzwanzig.chat.css') }}">
    </div>
</div>
