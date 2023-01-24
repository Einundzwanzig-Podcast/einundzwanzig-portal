<div wire:key="bitcoin_events_action_{{ $row->id }}">
    <a href="{{ $row->link }}" target="_blank">
        <x-badge class="whitespace-nowrap">{{ __('Link') }}</x-badge>
    </a>
</div>
