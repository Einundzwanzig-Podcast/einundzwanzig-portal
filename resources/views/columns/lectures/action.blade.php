<div wire:key="lecturers_action_{{ $row->id }}">
    @if($row->courses_count > 0)
        <x-button amber wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            {{ __('Show dates') }} ({{ $row->courses_count }})
        </x-button>
    @endif
    @if($row->courses_count < 1)
        <x-button outlined wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            {{ __('Show dates') }} ({{ $row->courses_count }})
        </x-button>
    @endif
    @if($row->library_items_count > 0)
        <x-button amber wire:click="lecturerSearch({{ $row->id }}, false)">
            <i class="fa fa-thin fa-book mr-2"></i>
            {{ __('Show content') }} ({{ $row->library_items_count }})
        </x-button>
    @endif
    @if($row->library_items_count < 1)
        <x-button outlined wire:click="lecturerSearch({{ $row->id }}, false)">
            <i class="fa fa-thin fa-book mr-2"></i>
            {{ __('Show content') }} ({{ $row->library_items_count }})
        </x-button>
    @endif
    <x-button
        :href="route('school.landingPage.lecturer', ['country' => $country, 'lecturer' => $row->slug])"
        amber>
        <i class="fa fa-thin fa-browser mr-2"></i>
        {{ __('Show landing page') }}
    </x-button>
</div>
