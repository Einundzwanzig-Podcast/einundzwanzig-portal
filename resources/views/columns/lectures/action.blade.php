<div>
    @if($row->courses_count > 0)
        <x-button amber wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            Termine anzeigen ({{ $row->courses_count }})
        </x-button>
    @endif
    @if($row->courses_count < 1)
        <x-button outlined wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-calendar mr-2"></i>
            Termine anzeigen ({{ $row->courses_count }})
        </x-button>
    @endif
    @if($row->library_items_count > 0)
        <x-button amber wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-book mr-2"></i>
            Inhalte anzeigen ({{ $row->library_items_count }})
        </x-button>
    @endif
    @if($row->library_items_count < 1)
        <x-button outlined wire:click="lecturerSearch({{ $row->id }})">
            <i class="fa fa-thin fa-book mr-2"></i>
            Inhalte anzeigen ({{ $row->library_items_count }})
        </x-button>
    @endif
</div>
