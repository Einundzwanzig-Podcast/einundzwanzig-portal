<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">
            <h1 class="mb-6 text-5xl font-extrabold leading-none tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                Bitcoiner <span
                    class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">Meetups</span><br
                    class="lg:block hidden">
                Plebs together strong 💪
            </h1>
            <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl lg:px-24"> Finde Bitcoiner in deiner Stadt und lerne
                sie auf einem der Meetups kennen. </p>
            <div
                wire:ignore
                class="w-full flex justify-center"
                x-data="{
                    init() {
                        let markers = {{ Js::from($markers) }};
                        console.log(markers);

                        $('#map').vectorMap({
                            zoomButtons : false,
                            zoomOnScroll: true,
                            map: '{{ $country->code }}_merc',
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
                <div id="map" style="width: 100%; height: 400px"></div>
            </div>
        </div>
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <livewire:tables.meetup-table :country="$country->code"/>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
