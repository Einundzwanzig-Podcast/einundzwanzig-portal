<div class="flex items-center space-x-2">
    <img class="h-12" src="{{ $row->getFirstMediaUrl('logo', 'thumb') }}" alt="{{ $row->title }}">
    <div>
        {{ $row->title }}
    </div>
</div>
