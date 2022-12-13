<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div
            class="w-full flex justify-center"
            x-data="{
                    init() {
                        let markers = [{name: 'VAK', coords: [50.0091294, 9.0371812], status: 'closed', offsets: [0, 2]}];

                        $('#map').vectorMap({
                            zoomButtons : false,
                            zoomOnScroll: false,
                            map: '{{ $country->code }}_merc',
                            backgroundColor: 'transparent',
                            // markers: markers.map(function(h){ return {name: h.name, latLng: h.coords} }),
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
            <div id="map" style="width: 600px; height: 400px"></div>
        </div>
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <livewire:tables.meetup-table :country="$country->code"/>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
