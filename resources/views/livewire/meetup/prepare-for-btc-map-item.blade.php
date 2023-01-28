<div class="p-6 w-full" wire:loading.class="opacity-50">

    <div class="max-w-none text-white flex flex-col space-y-4">
        <a href="{{ route('osm.meetups') }}">Zurück</a>
        <div class="grid grid-cols-3 gap-2">
            <div>
                <h1>Search city: {{ $meetup->city->name }}</h1>
                <h1>OSM API Response</h1>
                <div class="flex flex-col space-y-2">
                    @foreach($osmSearchResults as $item)
                        <code class="w-full">
                            <div wire:key="osmItemCity_{{ $loop->index }}" class="cursor-pointer underline"
                                 wire:click="selectItem({{ $loop->index }})">
                                {{ $item['display_name'] }}
                            </div>
                        </code>
                    @endforeach
                </div>
            </div>
            <div>
                <h1>Search state: {{ $meetup->city->name }}</h1>
                <h1>OSM API Response</h1>
                <div class="flex flex-col space-y-2">
                    @foreach($osmSearchResultsState as $item)
                        <code class="w-full">
                            <div wire:key="osmItemState_{{ $loop->index }}" class="cursor-pointer underline"
                                 wire:click="selectItem({{ $loop->index }}, true)">
                                {{ $item['display_name'] }}
                            </div>
                        </code>
                    @endforeach
                </div>
            </div>
            <div>
                <h1>Search country: {{ $meetup->city->name }}</h1>
                <h1>OSM API Response</h1>
                <div class="flex flex-col space-y-2">
                    @foreach($osmSearchResultsCountry as $item)
                        <code class="w-full">
                            <div wire:key="osmItemCountry_{{ $loop->index }}" class="cursor-pointer underline"
                                 wire:click="selectItem({{ $loop->index }}, false, true)">
                                {{ $item['display_name'] }}
                            </div>
                        </code>
                    @endforeach
                </div>
            </div>
        </div>
        <div>
            @if($selectedItem)
                geojson created
            @endif
        </div>
        <h1>Current data [points: {{ count($meetup->city->simplified_geojson['coordinates'][0] ?? []) }}]</h1>
        <div class="flex space-x-2">
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(7)">7%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(6)">6%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(5)">5%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(4)">4%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(3)">3%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(2)">2%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(1)">1%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(0.75)">0.75%</div>
            <div class="cursor-pointer font-bold underline" wire:click="setPercent(0.5)">0.5%</div>
        </div>
        <div>
            @if($meetup->city->simplified_geojson)
                <h1>Simplified geojson</h1>
                <pre
                    class="overflow-x-auto py-4">{{ json_encode($meetup->city->simplified_geojson, JSON_THROW_ON_ERROR) }}</pre>
                <div
                    class="my-4"
                    x-data="{
                        init() {
                            var map = L.map($refs.map)
                            .setView([{{ $meetup->city->longitude }}, {{ $meetup->city->latitude }}], 13);

                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

                            var geojsonFeature = {
                                'type': 'Feature',
                                'geometry': @js($meetup->city->simplified_geojson)
                            };
                            console.log(geojsonFeature);
                            L.geoJSON(geojsonFeature).addTo(map);
                            let geoJSON = L.geoJson(geojsonFeature).addTo(map);
                            map.fitBounds(geoJSON.getBounds());
                        }
                    }">
                    <div x-ref="map" style="width: 80vw; height: 30vh;"></div>
                </div>
            @endif
        </div>
        <div class="flex flex-col">
            @if($meetup->city->osm_relation)
                <code>
                    osm_id: {{ $meetup->city->osm_relation['osm_id'] }}
                </code>
                <code>
                    display_name: {{ $meetup->city->osm_relation['display_name'] }}
                </code>
            @endif
        </div>
        <h1>Wikipedia Search Results</h1>
        <div class="flex space-x-2">
            <a target="_blank" class="underline text-amber-500"
               href="https://de.wikipedia.org/wiki/{{ urlencode($meetup->city->name) }}">Wikipedia: {{ $meetup->city->name }}</a>
            <x-input wire:model.debounce="population" label="population"/>
            <x-input wire:model.debounce="population_date" label="population_date"/>
        </div>
        <h1>DB population</h1>
        <code>
            population: {{ $meetup->city->population }}
        </code>
        <code>
            population date: {{ $meetup->city->population_date }}
        </code>
    </div>
</div>
