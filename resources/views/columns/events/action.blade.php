<div wire:key="course_events_action_{{ $row->id }}">
    <x-button class="whitespace-nowrap" amber wire:click="viewHistoryModal({{ $row->id }})">{{ __('Register') }}</x-button>
</div>
