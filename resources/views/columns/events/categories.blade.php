<div class="flex space-x-1">
    @foreach($row->course->categories as $category)
        <x-badge class="whitespace-nowrap">{{ $category->name }}</x-badge>
    @endforeach
</div>
