<div class="flex flex-wrap items-center">
    @foreach($row->tags as $tag)
        <x-badge class="whitespace-nowrap m-1">{{ $tag->name }}</x-badge>
    @endforeach
</div>
