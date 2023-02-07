<div class="flex flex-col space-y-1">
    <div>
        <x-badge class="whitespace-nowrap">{{ __('Confirmations') }}: {{ count($row->attendees ?? []) }}</x-badge>
    </div>
    <div>
        <x-badge class="whitespace-nowrap">{{ __('Perhaps') }}: {{ count($row->might_attendees ?? []) }}</x-badge>
    </div>
</div>
