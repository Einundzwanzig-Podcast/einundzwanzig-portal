<div class="flex items-center">
    @foreach($row->tags as $tag)
        <x-badge>{{ $tag->name }}</x-badge>
    @endforeach
</div>
