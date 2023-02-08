<div class="bg-21gray h-screen justify-between">
    <livewire:frontend.header :country="$country"/>
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
                            'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',{
                                attribution: '...',
                                maxZoom: 18
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
                            zoom: 4,
                            maxZoom: 10,
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
</div>
