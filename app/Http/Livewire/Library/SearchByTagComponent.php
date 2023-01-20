<?php

namespace App\Http\Livewire\Library;

use App\Models\Tag;
use Livewire\Component;

class SearchByTagComponent extends Component
{
    public string $country = 'de';
    public array $filters = [];

    protected $queryString = [
        'filters'    => ['except' => ''],
    ];

    public function render()
    {
        $shouldBePublic = request()
                              ->route()
                              ->getName() !== 'library.table.lecturer';

        return view('livewire.library.search-by-tag-component', [
            'tags' => Tag::query()
                         ->with([
                             'libraryItems.libraries',
                             'libraryItems.lecturer',
                         ])
                         ->withCount([
                             'libraryItems',
                         ])
                         ->where('type', 'library_item')
                         ->whereHas('libraryItems.libraries', fn($query) => $query->where('is_public', $shouldBePublic))
                         ->orderByDesc('library_items_count')
                         ->orderBy('tags.id')
                         ->get(),
        ]);
    }
}
