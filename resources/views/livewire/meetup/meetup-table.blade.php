<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4 py-4">
            <div class="w-full flex justify-end">
                <x-button
                    x-data="{
                    textToCopy: '{{ route('meetup.ics', ['country' => $country]) }}',
                    }"
                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
                    amber>
                    <i class="fa fa-thin fa-calendar-arrow-down mr-2"></i>
                    {{ __('Calendar Stream-Url for all meetup events') }}
                </x-button>
            </div>
            <div class="flex flex-col sm:flex-row">
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
                    class="w-full flex justify-center"
                    x-data="{
                        init() {
                            let markers = {{ Js::from($markers) }};

                            $('#map').vectorMap({
                                {{ $focus }}
                                zoomButtons : true,
                                zoomOnScroll: true,
                                map: '{{ $map }}',
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
                    <div id="map" style="width: 100%;" class="h-[200px] sm:h-[400px] my-4 sm:my-0"></div>
                </div>
            </div>
        </div>
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
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
