<div class="flex flex-col space-y-1">
    @if($type === 'school')
        <div>
            @if($row->course_events_count > 0)
                <x-button amber wire:click="proximitySearch({{ $row->id }})" class="text-21gray">
                    <i class="fa fa-thin fa-person-chalkboard mr-2"></i>
                    Umkreis-Suche Kurs-Termin {{ $row->name }} (100km)
                </x-button>
            @endif
            @if($row->course_events_count < 1)
                <x-button outlined wire:click="proximitySearch({{ $row->id }})" class="text-21gray">
                    <i class="fa fa-thin fa-person-chalkboard mr-2"></i>
                    Umkreis-Suche Kurs-Termin {{ $row->name }} (100km)
                </x-button>
            @endif
        </div>
    @endif
    @if($type === 'bookCase')
        <div>
            <x-button amber wire:click="proximitySearchForBookCases({{ $row->id }})" class="text-21gray">
                <i class="fa fa-thin fa-book mr-2"></i>
                Umkreis-Suche Bücher-Schrank {{ $row->name }} (5km)
            </x-button>
        </div>
    @endif
</div>
