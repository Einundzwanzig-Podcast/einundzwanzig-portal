<div wire:key="courses_action_{{ $row->id }}">
    <x-button amber wire:click="courseSearch({{ $row->id }})">
        {{ __('Show dates') }}
    </x-button>
</div>
