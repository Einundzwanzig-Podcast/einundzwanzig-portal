<div>
    @if($row->meetup_events_count > 0)
        <x-button
            amber
            wire:click="meetupEventSearch({{ $row->id }})">
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>
    @endif
    @if($row->meetup_events_count < 1)
        <x-button
            outlined
            wire:click="meetupEventSearch({{ $row->id }})">
            {{ __('Show dates') }} ({{ $row->meetup_events_count }})
        </x-button>
    @endif
</div>
