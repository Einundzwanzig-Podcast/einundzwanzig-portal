<div class="flex items-center space-x-2">
    <img class="h-12" src="{{ $row->course->lecturer->getFirstMediaUrl('avatar', 'thumb') }}" alt="{{ $row->course->lecturer->name }}">
    <div>
        {{ $row->course->lecturer->name }}
    </div>
</div>
