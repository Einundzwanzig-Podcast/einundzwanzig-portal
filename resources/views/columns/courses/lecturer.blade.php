<div class="flex items-center space-x-2">
    <img class="h-12" src="{{ $row->lecturer->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $row->lecturer->name }}">
    <div>
        {{ $row->lecturer->name }}
    </div>
</div>
