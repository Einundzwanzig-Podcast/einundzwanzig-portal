<div class="flex flex-col space-y-1">
    <div>
        @if($row->courses_count > 0)
            <x-button
                xs amber wire:click="lecturerSearch({{ $row->id }})">
                <i class="fa fa-thin fa-calendar mr-2"></i>
                {{ __('Show dates') }} ({{ $row->courses_count }})
            </x-button>
        @endif
    </div>
    <div>
        @if($row->courses_count < 1)
            <x-button
                xs outlined wire:click="lecturerSearch({{ $row->id }})">
                <i class="fa fa-thin fa-calendar mr-2"></i>
                {{ __('Show dates') }} ({{ $row->courses_count }})
            </x-button>
        @endif
    </div>
    <div>
        @if($row->library_items_count > 0)
            <x-button
                xs amber wire:click="lecturerSearch({{ $row->id }}, false)">
                <i class="fa fa-thin fa-book mr-2"></i>
                {{ __('Show content') }} ({{ $row->library_items_count }})
            </x-button>
        @endif
    </div>
    <div>
        @if($row->library_items_count < 1)
            <x-button
                xs outlined wire:click="lecturerSearch({{ $row->id }}, false)">
                <i class="fa fa-thin fa-book mr-2"></i>
                {{ __('Show content') }} ({{ $row->library_items_count }})
            </x-button>
        @endif
    </div>
    <div>
        <x-button
            xs
            :href="route('school.landingPage.lecturer', ['country' => $country, 'lecturer' => $row->slug])"
            black>
            <i class="fa fa-thin fa-browser mr-2"></i>
            {{ __('Show landing page') }}
        </x-button>
    </div>
    <div>
        @if($row->created_by === auth()->id())
            <x-button
                :href="route('contentCreator.form', ['country' => $country, 'lecturer' => $row->id])"
                xs
                amber
            >
                <i class="fa fa-thin fa-edit mr-2"></i>
                {{ __('Edit') }}
            </x-button>
        @endif
    </div>
</div>
