<div wire:key="venues_action_{{ $row->id }}">
    @if($row->course_events_count > 0)
        <x-button amber wire:click="venueSearch({{ $row->id }})">
            {{ __('Show dates') }} ({{ $row->course_events_count }})
        </x-button>
    @endif
    @if($row->course_events_count < 1)
        <x-button outlined wire:click="venueSearch({{ $row->id }})">
            {{ __('Show dates') }} ({{ $row->course_events_count }})
        </x-button>
    @endif
</div>
