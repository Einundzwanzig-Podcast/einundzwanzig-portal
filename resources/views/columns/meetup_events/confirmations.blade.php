<div class="flex flex-col space-y-1">
    <div>
        @if(count($row->attendees ?? []) > 0)
            <x-badge green class="whitespace-nowrap">{{ __('Confirmations') }}
                : {{ count($row->attendees ?? []) }}</x-badge>
        @else
            <x-badge class="whitespace-nowrap">{{ __('Confirmations') }}: {{ count($row->attendees ?? []) }}</x-badge>
        @endif
    </div>
    <div>
        @if(count($row->might_attendees ?? []) > 0)
            <x-badge green class="whitespace-nowrap">{{ __('Perhaps') }}
                : {{ count($row->might_attendees ?? []) }}</x-badge>
        @else
            <x-badge class="whitespace-nowrap">{{ __('Perhaps') }}: {{ count($row->might_attendees ?? []) }}</x-badge>
        @endif
    </div>
</div>
