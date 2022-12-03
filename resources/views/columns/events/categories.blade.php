<div class="flex space-x-1">
    @foreach($row->course->categories as $category)
        <x-badge>{{ $category->name }}</x-badge>
    @endforeach
</div>
