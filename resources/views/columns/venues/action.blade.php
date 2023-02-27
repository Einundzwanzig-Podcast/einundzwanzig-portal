<div class="flex flex-col space-y-1">
    <div>
        @if($row->course_events_count > 0 && !$manage)
            <x-button xs amber wire:click="venueSearch({{ $row->id }})">
                {{ __('Show dates') }} ({{ $row->course_events_count }})
            </x-button>
        @endif
    </div>
    <div>
        @if($row->course_events_count < 1 && !$manage)
            <x-button xs outlined wire:click="venueSearch({{ $row->id }})">
                {{ __('Show dates') }} ({{ $row->course_events_count }})
            </x-button>
        @endif
    </div>
    <div>
        @can('update', $row)
            <x-button primary xs :href="route('venue.form', ['venue' => $row])">
                <i class="fa-thin fa-edit"></i>
                {{ __('Edit') }}
            </x-button>
        @endif
    </div>
</div>
