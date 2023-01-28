<div class="flex flex-col space-y-1">
    <div>
        @if($row->osm_relation)
            has OSM relation
        @endif
    </div>
    <div>
        population {{ $row->population }}
    </div>
    <div>
        @if($row->population_date)
            population date {{ $row->population_date }}
        @endif
    </div>
    <div>
        <x-button
            xs
            amber
            :href="route('osm.meetups.item', ['meetup' => $row])"
        >
            Open OSM Item
        </x-button>
    </div>
</div>
