<div class="flex items-center">
    @foreach($row->tags as $tag)
        <x-badge class="whitespace-nowrap">{{ $tag->name }}</x-badge>
    @endforeach
</div>
