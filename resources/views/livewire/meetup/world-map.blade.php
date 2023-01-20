<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 flex flex-col sm:flex-row">
            <div class="flex flex-col">
                <h1 class="mb-6 text-5xl font-extrabold leading-none tracking-normal text-gray-200 sm:text-6xl md:text-6xl lg:text-7xl md:tracking-tight">
                    {{ __('Bitcoiner') }} <span
                        class="w-full text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-amber-500 to-amber-200 lg:inline">{{ __('Meetups') }}</span><br
                        class="lg:block hidden">
                    {{ __('Plebs together strong 💪') }}
                </h1>
                <p class="px-0 mb-6 text-lg text-gray-600 md:text-xl">
                    {{ __('Bitcoiner Meetups are a great way to meet other Bitcoiners in your area. You can learn from each other, share ideas, and have fun!') }}
                </p>
            </div>
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

    <div class="w-full py-24">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">
            <livewire:tables.meetup-table :country="null"/>
        </div>
    </div>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
