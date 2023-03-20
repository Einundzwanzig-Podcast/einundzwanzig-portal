<div class="flex items-center space-x-2">
    <img class="h-12" src="{{ $row->user->profile_photo_url }}" alt="{{ $row->user->name }}">
    <div>
        {{ str($row->user->name)->limit(10) }}
    </div>
</div>
