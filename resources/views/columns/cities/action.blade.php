<div class="flex flex-col space-y-1">
    @if($type === 'school')
        <div>
            <div>
                @if($row->course_events_count > 0)
                    <x-button amber wire:click="proximitySearch({{ $row->id }})" class="text-21gray">
                        <i class="fa fa-thin fa-person-chalkboard mr-2"></i>
                        {{ __('Perimeter search course date :name (100km)', ['name' => $row->name]) }}
                    </x-button>
                @endif
            </div>
            <div>
                @if($row->course_events_count < 1)
                    <x-button outlined wire:click="proximitySearch({{ $row->id }})" class="text-21gray">
                        <i class="fa fa-thin fa-person-chalkboard mr-2"></i>
                        {{ __('Perimeter search course date :name (100km)', ['name' => $row->name]) }}
                    </x-button>
                @endif
            </div>
        </div>
    @endif
    <div>
        @if($type === 'bookCase')
            <div>
                <x-button amber wire:click="proximitySearchForBookCases({{ $row->id }})" class="text-21gray">
                    <i class="fa fa-thin fa-book mr-2"></i>
                    {{ __('Perimeter search bookcase :name (25km)', ['name' => $row->name]) }}
                </x-button>
            </div>
        @endif
    </div>
</div>
