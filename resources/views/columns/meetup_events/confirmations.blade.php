<div class="flex flex-col space-y-1">
    <div>
        <x-badge>{{ __('Confirmations') }}: {{ count($row->attendees ?? []) }}</x-badge>
    </div>
    <div>
        <x-badge>{{ __('Perhaps') }}: {{ count($row->might_attendees ?? []) }}</x-badge>
    </div>
</div>
