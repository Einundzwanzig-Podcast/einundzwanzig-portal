<div class="bg-21gray flex flex-col h-screen justify-between">
    {{-- HEADER --}}
    <livewire:frontend.header :country="$country"/>
    {{-- MAIN --}}
    <section class="w-full mb-12">
        <div class="max-w-screen-2xl mx-auto px-2 sm:px-10 space-y-4" id="table">

            <div class="w-full flex justify-end">
                <x-button
                    x-data="{
                    textToCopy: '{{ route('bitcoinEvent.ics', ['country' => $country]) }}',
                    }"
                    @click.prevent="window.navigator.clipboard.writeText(textToCopy);window.$wireui.notify({title:'{{ __('Calendar Stream Url copied!') }}',description:'{{ __('Paste the calendar stream link into a compatible calendar app.') }}',icon:'success'});"
                    amber>
                    <i class="fa fa-thin fa-calendar-arrow-down mr-2"></i>
                    {{ __('Calendar Stream-Url') }} ({{ $events->count() }})
                </x-button>
            </div>

            <div class="flex items-start">
                <div class="w-full sm:w-1/2">

                    @php
                        $locale = \Illuminate\Support\Facades\Cookie::get('lang', 'de');
                    @endphp

                    <link rel="stylesheet" type="text/css"
                          href="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.css"/>
                    <script src="https://unpkg.com/js-year-calendar@latest/dist/js-year-calendar.min.js"></script>
                    <script src="https://unpkg.com/js-year-calendar@latest/locales/js-year-calendar.{{ $locale }}.js"></script>

                    <style>
                        .calendar {
                            max-height: 280px;
                        }
                        .calendar .calendar-header {
                            background-color: #F7931A;
                            color: white;
                            border: 0;
                        }

                        .calendar table.month th.month-title {
                            color: #F7931A;
                        }

                        .calendar table.month th.day-header {
                            color: #fff;
                        }

                        .calendar table.month td.day .day-content {
                            color: #fff;
                        }

                        .calendar .calendar-header table th:hover {
                            background: #222;
                        }
                    </style>

                    <div
                        wire:ignore
                        x-data="{
                        calendar: null,
                        init() {
                            let events = {{ Js::from($events) }};
                            events = events.map(function(e){
                                return {id: e.id, startDate: new Date(e.startDate), endDate: new Date(e.endDate), location: e.location, description: e.description}
                            })

                            new Calendar(this.$refs.calendar, {
                                style: 'background',
                                language: '{{ $locale }}',
                                startYear: {{ $year }},
                                dataSource: events,
                                yearChanged: function(e) {
                                    @this.set('year', e.currentYear);
                                },
                                clickDay: function(e) {
                                    if(e.events.length > 0) {
                                        var content = '';
                                        var ids = [];

                                        for(var i in e.events) {
                                            ids.push(e.events[i].id);
                                            content += '<div class=\'event-tooltip-content\'>'
                                            + '<div class=\'event-name\'>' + e.events[i].location + '</div>'
                                            + '<div class=\'event-location\'>' + e.events[i].description + '</div>'
                                            + '</div>';
                                        }
                                        console.log(content);

                                        $wire.call('popover', content, ids.join(','));
                                    }
                                },
                            });
                        },
                    }"
                    >
                        <div x-ref="calendar"></div>
                    </div>
                </div>
                <div class="hidden sm:inline sm:w-1/2">
                    <div
                        wire:ignore
                        class="w-full flex justify-center"
                        x-data="{
                            init() {
                                let markers = {{ Js::from($markers) }};
                                console.log(markers);

                                $('#map').vectorMap({
                                    zoomButtons : true,
                                    zoomOnScroll: true,
                                    map: 'world_mill',
                                    height: 300,
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
                        <div id="map" style="width: 100%; height: 300px"></div>
                    </div>
                </div>
            </div>

            <livewire:tables.bitcoin-event-table :country="$country->code"/>
        </div>
    </section>
    {{-- FOOTER --}}
    <livewire:frontend.footer/>
</div>
