<div>
    <x-button amber wire:click="lecturerSearch({{ $row->id }})">
        <i class="fa fa-thin fa-calendar mr-2"></i>
        Termine anzeigen
    </x-button>
    <x-button amber wire:click="lecturerSearch({{ $row->id }})">
        <i class="fa fa-thin fa-book mr-2"></i>
        Inhalte anzeigen
    </x-button>
</div>
