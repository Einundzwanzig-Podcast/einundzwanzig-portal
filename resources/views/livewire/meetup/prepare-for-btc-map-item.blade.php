<div>
    <div class="w-full p-0 lg:p-6" wire:loading.class="opacity-50 pointer-events-none cursor-not-allowed">
        <div class="flex max-w-none flex-col space-y-4 text-black">

            {{-- SEARCH PANEL --}}
            <div class="rounded-lg bg-white shadow dark:bg-gray-800">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="px-4 py-5 lg:p-6">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                            {{ $meetup->name }}
                        </h3>
                        <div class="mt-2 text-sm text-gray-500">

                            <form wire:submit.prevent="submit" class="space-y-2">
                                @if (!$model?->simplified_geojson || !$selectedItemOSMPolygons)
                                    <div class="flex flex-col space-y-2 lg:flex-row lg:space-y-0 lg:space-x-2">
                                        <div>
                                            <x-input wire:model.defer="search"/>
                                        </div>
                                        <div>
                                            <x-button type="submit" class='w-full font-semibold'>Search</x-button>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex flex-col space-y-2">
                                        <a href="{{ route('osm.meetups') }}">
                                            <x-badge gray class="whitespace-nowrap dark:bg-gray-200 dark:text-black">
                                                Back
                                            </x-badge>
                                        </a>
                                        <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-900">
                                            <div class="px-2 py-2 sm:px-4 sm:py-5 sm:px-6">
                                                <h3
                                                    class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-200">
                                                    {{ $selectedItemOSMPolygons['display_name'] }}
                                                </h3>
                                                <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">

                                                </p>
                                            </div>
                                            <div class="border-t border-gray-200 px-2 py-2 sm:p-0 sm:px-4 sm:py-5">
                                                <dl class="sm:divide-y sm:divide-gray-200">
                                                    <div class="space-y-1 py-2 sm:py-4 sm:py-5">
                                                        <dt
                                                            class="text-sm font-medium text-gray-500 dark:text-gray-300">
                                                            <x-badge
                                                                blue>{{ $selectedItemOSMPolygons['type'] }}</x-badge>
                                                        </dt>
                                                        <dd class="text-sm text-gray-900 dark:text-gray-300">
                                                            OSM ID: {{ $selectedItemOSMPolygons['osm_id'] }}
                                                        </dd>
                                                    </div>
                                                </dl>
                                            </div>
                                        </div>
                                        <div class="overflow-hidden rounded-lg bg-white shadow dark:bg-gray-900">
                                            <div class="px-2 py-2 sm:px-4 sm:py-5 sm:px-6">
                                                <div class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                                                    <x-toggle red lg
                                                              label="Fetch water boundaries from https://osm-boundaries.com"
                                                              wire:model="OSMBoundaries"/>
                                                </div>
                                                <div x-data="{
                                                    show: @entangle('polygonsOSMfr')
                                                }"
                                                     class="mt-2 max-w-2xl text-sm text-gray-500 dark:text-gray-300">
                                                    <x-toggle red lg
                                                              label="Fetch polygons from https://polygons.openstreetmap.fr"
                                                              wire:model="polygonsOSMfr"/>
                                                    <div class="mt-2 flex flex-row items-end space-x-2" x-show="show">
                                                        <x-input max="1" label="X"
                                                                 wire:model.defer="polygonsOSMfrX"/>
                                                        <x-input max="1" label="Y"
                                                                 wire:model.defer="polygonsOSMfrY"/>
                                                        <x-input max="1" label="Z"
                                                                 wire:model.defer="polygonsOSMfrZ"/>
                                                    </div>
                                                    <div class="mt-4 font-mono text-sm" x-show="show">
                                                        <p>
                                                            X, Y, Z are parameters for the following PostGIS equation.
                                                            The default values are chosen according to the size of the
                                                            original geometry to give a slighty bigger geometry, without
                                                            too many nodes.

                                                        </p>
                                                        <p class="mt-4">Note that:</p>
                                                        <p>
                                                            X > 0 will give a polygon bigger than the original geometry,
                                                            and guaranteed to contain it.
                                                        </p>
                                                        <p>
                                                            X = 0 will give a polygon similar to the original geometry.
                                                        </p>
                                                        <p>
                                                            X < 0 will give a polygon smaller than the original
                                                            geometry, and guaranteed to be smaller. </p>
                                                    </div>
                                                    <div x-show="show" class="mt-2 font-semibold">
                                                        <x-button emerald label="Submit and load polygons"
                                                                  wire:click="submitPolygonsOSM"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div>
                                    @if (!$model?->simplified_geojson && $search)
                                        <x-badge lg positive class="xl:whitespace-nowrap">
                                            Now select the appropriate place so that a GeoJSON can be built.
                                        </x-badge>
                                    @endif
                                </div>
                            </form>

                        </div>
                    </div>
                    <div class="overflow-y-auto px-4 py-5 lg:p-6">
                        @if ($search)
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                Search: {{ $search }}
                            </h3>
                        @endif
                        <div class="mt-2 text-sm text-gray-500">

                            <div class="flex max-h-[400px] flex-col space-y-4">
                                <div class="mt-6 flow-root">
                                    <ul role="list" class="-my-5 divide-y divide-gray-200">

                                        @foreach ($osmSearchResults as $item)
                                            @php
                                                $currentClass = $item['osm_id'] === $osm_id ? 'bg-amber-400 dark:bg-amber-900' : '';
                                            @endphp

                                            <li class="{{ $currentClass }} cursor-pointer py-4 px-2 hover:bg-amber-400 dark:hover:bg-amber-800"
                                                wire:key="osmItem_{{ $loop->index }}"
                                                wire:click="selectItem({{ $loop->index }})">
                                                <div class="flex items-center space-x-4">
                                                    <div class="min-w-0 flex-1">
                                                        <p
                                                            class="truncate text-sm font-medium text-gray-900 dark:text-gray-200">
                                                            {{ $item['display_name'] }}</p>
                                                        <p class="truncate text-sm text-gray-500">
                                                            <x-badge amber>
                                                                {{ count($item['geojson']['coordinates'], COUNT_RECURSIVE) }}
                                                                points
                                                            </x-badge>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <x-badge blue>{{ $item['type'] }}</x-badge>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- Wikipedia Links --}}
            <div class="flex flex-row items-center space-x-6">
                @if ($search)
                    <div class='rounded-lg bg-white px-4 py-5 shadow dark:bg-gray-800 lg:p-6'>
                        <h1 class='font-semibold dark:text-gray-100'>Wikipedia search <span
                                class='text-sm text-gray-500 dark:text-gray-400'>(for population data)</span></h1>
                        <div class="flex flex-wrap gap-2">
                            <a target="_blank" class="text-amber-500 underline"
                               href="https://en.wikipedia.org/wiki/{{ urlencode(str($search)->replace(' ', '_')->toString()) }}">Wikipedia
                                EN:
                                {{ $search }}</a>
                            <a target="_blank" class="text-amber-500 underline"
                               href="https://de.wikipedia.org/wiki/{{ urlencode(str($search)->replace(' ', '_')->toString()) }}">Wikipedia
                                DE:
                                {{ $search }}</a>
                            <a target="_blank" class="text-amber-500 underline"
                               href="https://fr.wikipedia.org/wiki/{{ urlencode(str($search)->replace(' ', '_')->toString()) }}">Wikipedia
                                FR:
                                {{ $search }}</a>
                            <a target="_blank" class="text-amber-500 underline"
                               href="https://es.wikipedia.org/wiki/{{ urlencode(str($search)->replace(' ', '_')->toString()) }}">Wikipedia
                                ES:
                                {{ $search }}</a>
                        </div>
                    </div>
                @endif
                <div class='rounded-lg bg-white px-4 py-5 shadow dark:bg-gray-800 lg:p-6'>
                    <x-input wire:model.debounce="population" label="population"/>
                    <x-input wire:model.debounce="population_date" label="population_date"/>
                </div>
            </div>

            {{-- GeoJSON simplification --}}
            @if ($model && $selectedItemOSMPolygons)
                <div class="rounded-lg bg-white shadow dark:bg-gray-800">
                    <div class="px-4 py-5 lg:p-6">
                        <div class="flex items-center space-x-4">
                            <h3 class="text-lg font-medium leading-6 text-blue-500">
                                Mapshaper simplification of <span class="text-[#FFA500]">OSM GeoJSON
                                    [{{ count($selectedItemOSMPolygons['geojson']['coordinates'], COUNT_RECURSIVE) }}
                                    points]</span> to
                                {{ count($model->simplified_geojson['coordinates'] ?? [], COUNT_RECURSIVE) }} points
                            </h3>
                        </div>
                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-200">
                            <div class="flex flex-col space-y-2">
                                <h1 class="py-2">
                                    (smaller percentage means fewer points - aim for no more than 150)
                                </h1>
                                <div class="flex hidden space-x-2 overflow-auto lg:block">
                                    @php
                                        $btnClassLeft = 'relative inline-flex items-center rounded-l-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 dark:bg-gray-600 dark:hover:bg-blue-800 hover:bg-blue-400 focus:z-10 focus:border-blue-500 dark:focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-700';
                                        $btnClassRight = 'relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 dark:bg-gray-600 dark:hover:bg-blue-800 hover:bg-blue-400 focus:z-10 focus:border-blue-500 dark:focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-700';
                                        $btnClassCenter = 'relative -ml-px inline-flex items-center border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 dark:bg-gray-600 dark:hover:bg-blue-800 hover:bg-blue-400 focus:z-10 focus:border-blue-500 dark:focus:border-blue-700 focus:outline-none focus:ring-1 focus:ring-blue-500 dark:focus:ring-blue-700';
                                        $currentClass = 'bg-blue-500 dark:bg-blue-700 text-white dark:text-gray-900';
                                    @endphp
                                    <div class="isolate inline-flex rounded-md shadow-sm">
                                        @foreach ($percentages as $percentage)
                                            @php
                                                $btnClass = $loop->first ? $btnClassLeft : ($loop->last ? $btnClassRight : $btnClassCenter);
                                            @endphp
                                            <button wire:key="percentage_{{ $loop->index }}" type="button"
                                                    wire:click="setPercentage({{ $percentage }})"
                                                    class="{{ $btnClass }} {{ $currentPercentage === $percentage ? $currentClass : '' }}">
                                                {{ $percentage }}%
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="block lg:hidden">
                                    <x-native-select label="Select percentage" placeholder="Select percentage"
                                                     :options="$percentages" wire:model="currentPercentage"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            {{-- GeoJSON data --}}
            <div>
                @if ($model?->simplified_geojson && $selectedItemOSMPolygons)
                    <div class="rounded-lg bg-white shadow dark:bg-gray-800">
                        <div class="grid grid-cols-1 gap-4 px-4 py-5 lg:grid-cols-2 lg:p-6">
                            <div>
                                @php
                                    $jsonEncodedSelectedItem = json_encode($selectedItemOSMPolygons['geojson'], JSON_THROW_ON_ERROR);
                                @endphp
                                <h3 class="text-lg font-medium leading-6 text-[#FFA500]">
                                    OSM GeoJSON
                                    [{{ count($selectedItemOSMPolygons['geojson']['coordinates'] ?? [], COUNT_RECURSIVE) }}
                                    points]
                                </h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <div class="flex w-full flex-col space-y-2">
                                        <pre
                                            class="overflow-x-auto py-3 text-[#FFA500]">{{ $jsonEncodedSelectedItem }}</pre>
                                        <div class='font-semibold'>
                                            <x-button x-data="{
                                                textToCopy: @entangle('selectedItemOSMPolygons.geojson')
                                            }"
                                                      @click.prevent="window.navigator.clipboard.writeText(JSON.stringify(textToCopy));window.$wireui.notify({title:'{{ __('Copied!') }}',icon:'success'});"
                                                      lg amber>
                                                Copy to clipboard
                                            </x-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                @php
                                    $jsonEncodedSimplifiedGeoJson = json_encode($model->simplified_geojson, JSON_THROW_ON_ERROR);
                                @endphp
                                <h3 class="text-lg font-medium leading-6 text-blue-500">
                                    Simplified GeoJSON
                                    [{{ count($model->simplified_geojson['coordinates'] ?? [], COUNT_RECURSIVE) }}
                                    points]
                                </h3>
                                <div class="mt-2 text-sm text-gray-500">
                                    <div class="flex w-full flex-col space-y-2">
                                        <pre
                                            class="overflow-x-auto py-3 text-blue-500">{{ $jsonEncodedSimplifiedGeoJson }}</pre>
                                        <div class='font-semibold'>
                                            <x-button
                                                wire:click="saveSimplifiedGeoJson"
                                                lg blue>
                                                Save on model
                                            </x-button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($selectedItemOSMBoundaries)
                                <div>
                                    @php
                                        $jsonEncodedGeoJsonWater = json_encode($selectedItemOSMBoundaries, JSON_THROW_ON_ERROR);
                                    @endphp
                                    <h3 class="text-lg font-medium leading-6 text-[#FF0084]">
                                        https://osm-boundaries.com water GeoJSON
                                        [{{ count($selectedItemOSMBoundaries['coordinates'], COUNT_RECURSIVE) }}
                                        points]
                                    </h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <div class="flex w-full flex-col space-y-2">
                                            <pre
                                                class="overflow-x-auto py-3 text-[#FF0084]">{{ $jsonEncodedGeoJsonWater }}</pre>
                                            <div class='font-semibold'>
                                                <x-button x-data="{
                                                    textToCopy: @entangle('selectedItemOSMBoundaries')
                                                }"
                                                          @click.prevent="window.navigator.clipboard.writeText(JSON.stringify(textToCopy));window.$wireui.notify({title:'{{ __('Copied!') }}',icon:'success'});"
                                                          lg pink>
                                                    Copy to clipboard
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($selectedItemPolygonsOSMfr)
                                <div>
                                    @php
                                        $jsonEncodedGeoJsonOSMFr = json_encode($selectedItemPolygonsOSMfr, JSON_THROW_ON_ERROR);
                                    @endphp
                                    <h3 class="text-lg font-medium leading-6 text-emerald-500">
                                        https://polygons.openstreetmap.fr GeoJSON
                                        <span wire:key="ifNotGeometryCollection">
                                            @if ($selectedItemPolygonsOSMfr['type'] !== 'GeometryCollection')
                                                [{{ count($selectedItemPolygonsOSMfr['coordinates'] ?? [], COUNT_RECURSIVE) }}
                                                points]
                                            @endif
                                        </span>
                                    </h3>
                                    <div class="mt-2 text-sm text-gray-500">
                                        <div class="flex w-full flex-col space-y-2">
                                            <pre
                                                class="overflow-x-auto py-3 text-emerald-500">{{ $jsonEncodedGeoJsonOSMFr }}</pre>
                                            <div class='font-semibold'>
                                                <x-button x-data="{
                                                    textToCopy: @entangle('selectedItemPolygonsOSMfr')
                                                }"
                                                          @click.prevent="window.navigator.clipboard.writeText(JSON.stringify(textToCopy));window.$wireui.notify({title:'{{ __('Copied!') }}',icon:'success'});"
                                                          lg emerald>
                                                    Copy to clipboard
                                                </x-button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="flex flex-col space-y-4 px-4 py-5 lg:p-6">
                            <div class="w-full">
                                <div>
                                    <h1 class="font-bold dark:text-white">
                                        GeoJSON preview
                                    </h1>
                                    <div wire:ignore class="my-4" x-data="{
                                        geojson: @entangle('selectedItemOSMPolygons.geojson'),
                                        simplifiedGeojson: @entangle('model.simplified_geojson'),
                                        geojsonWater: @entangle('selectedItemOSMBoundaries'),
                                        geojsonOSMfr: @entangle('selectedItemPolygonsOSMfr'),
                                        init() {
                                            const map = L.map($refs.map)
                                                .setView([0, 0], 13);

                                            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', { foo: 'bar', attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors' }).addTo(map);

                                            const geojsonFeature = {
                                                'type': 'Feature',
                                                'geometry': this.geojson
                                            };
                                            const simplifiedGeojsonFeature = {
                                                'type': 'Feature',
                                                'geometry': this.simplifiedGeojson
                                            };
                                            L.geoJson(geojsonFeature, { style: { color: '#FFA500', fillColor: '#FFA500', fillOpacity: 0.3 } }).addTo(map);
                                            let simplifiedGeoJSON = L.geoJson(simplifiedGeojsonFeature, { style: { fillOpacity: 0.5 } }).addTo(map);
                                            map.fitBounds(simplifiedGeoJSON.getBounds(), { padding: [50, 50] });

                                            $wire.on('geoJsonUpdated', () => {
                                                map.eachLayer((layer) => {
                                                    layer.remove();
                                                });
                                                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', { foo: 'bar', attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors' }).addTo(map);
                                                const geojsonFeature = {
                                                    'type': 'Feature',
                                                    'geometry': this.geojson
                                                };
                                                const simplifiedGeojsonFeature = {
                                                    'type': 'Feature',
                                                    'geometry': this.simplifiedGeojson
                                                };
                                                const geojsonWaterFeature = {
                                                    'type': 'Feature',
                                                    'geometry': this.geojsonWater
                                                };
                                                const geojsonOSMfrFeature = {
                                                    'type': 'Feature',
                                                    'geometry': this.geojsonOSMfr
                                                };
                                                L.geoJson(geojsonFeature, { style: { color: '#FFA500', fillColor: '#FFA500', fillOpacity: 0.3 } }).addTo(map);
                                                L.geoJson(geojsonWaterFeature, { style: { color: '#FF0084', fillColor: '#FF0084', fillOpacity: 0.2 } }).addTo(map);
                                                L.geoJson(geojsonOSMfrFeature, { style: { color: '#10b981', fillColor: '#10b981', fillOpacity: 0.3 } }).addTo(map);
                                                let simplifiedGeoJSON = L.geoJson(simplifiedGeojsonFeature, { style: { fillOpacity: 0.5 } }).addTo(map);
                                                map.fitBounds(simplifiedGeoJSON.getBounds(), { padding: [50, 50] });
                                            });
                                        }
                                    }">
                                        <div x-ref="map" style="height: 50vh;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class='rounded-lg bg-white px-4 py-5 shadow dark:bg-gray-800 lg:p-6'>
                <p class="mt-8 text-xs leading-5 text-gray-400 md:order-1 md:mt-0">
                    <a class="text-blue-500" href="https://github.com/HolgerHatGarKeineNode/geojson-helper"
                       target="_blank">GeoJSON helper</a> is maintained by <a
                        href="https://github.com/HolgerHatGarKeineNode" target="_blank"
                        class="text-amber-500">HolgerHatGarKeineNode</a> [<span
                        class="break-all font-mono">npub1pt0kw36ue3w2g4haxq3wgm6a2fhtptmzsjlc2j2vphtcgle72qesgpjyc6</span>].
                    This
                    software is open-sourced software
                    licensed under the <a href="https://opensource.org/licenses/MIT" target="_blank"
                                          class="underline">MIT license</a>.
                </p>
            </div>
        </div>
    </div>

    <style>
        .leaflet-attribution-flag {
            display: inline;
        }
    </style>
</div>
