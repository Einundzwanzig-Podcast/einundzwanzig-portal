<div>
    @if(str($row->value)->contains('http'))
        <x-button amber href="{{ $row->value }}" target="_blank">
            <i class="fa fa-thin fa-book-open mr-2"></i>
            Öffnen
        </x-button>
    @endif
    @if($row->type === 'downloadable_file')
        <x-button amber href="{{ $row->getFirstMediaUrl('single_file') }}" target="_blank">
            <i class="fa fa-thin fa-download mr-2"></i>
            Download
        </x-button>
    @endif
</div>
