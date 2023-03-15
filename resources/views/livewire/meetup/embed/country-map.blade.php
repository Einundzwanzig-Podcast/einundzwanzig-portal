<div class="h-full bg-white">
    @php
        $focus = '';
        $map = $country->code . '_merc';
        if (!\File::exists(public_path('vendor/jvector/maps/' . $country->code . '.js'))) {
            $map = 'europe_merc';
            $focus = 'focusOn: {lat:'.$country->latitude.',lng:'.$country->longitude.',scale:8,animate:true},';
        }
    @endphp
    <div
        wire:ignore
        class="w-full flex justify-center h-full"
        x-data="{
            init() {
                let markers = {{ Js::from($markers) }};

                $('#map').vectorMap({
                    {{ $focus }}
                    zoomButtons : true,
                    zoomOnScroll: true,
                    map: '{{ $map }}',
                    backgroundColor: 'transparent',
                    markers: markers.map(function(h){ return {name: h.name, latLng: h.coords, url: h.url} }),
                    onMarkerClick: function(event, index) {
                        window.open(
                          markers[index].url,
                          '_blank'
                        );
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
        <div id="map" style="width: 100%; height: 100vh;" class="my-4 sm:my-0"></div>
    </div>
</div>
