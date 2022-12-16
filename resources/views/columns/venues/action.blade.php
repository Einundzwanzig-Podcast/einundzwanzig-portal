<div>
    @if($row->course_events_count > 0)
        <x-button amber wire:click="venueSearch({{ $row->id }})">
            Termine anzeigen ({{ $row->course_events_count }})
        </x-button>
    @endif
    @if($row->course_events_count < 1)
        <x-button outlined wire:click="venueSearch({{ $row->id }})">
            Termine anzeigen ({{ $row->course_events_count }})
        </x-button>
    @endif
</div>
