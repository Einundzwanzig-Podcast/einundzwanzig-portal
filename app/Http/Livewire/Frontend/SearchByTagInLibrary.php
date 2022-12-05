<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Tag;
use Livewire\Component;

class SearchByTagInLibrary extends Component
{
    public string $country = 'de';
    public ?array $table = [];

    protected $queryString = [
        'table',
    ];

    public function render()
    {
        return view('livewire.frontend.search-by-tag-in-library', [
            'tags' => Tag::query()
                         ->with([
                             'libraryItems.libraries',
                             'libraryItems.lecturer',
                         ])
                         ->withCount([
                             'libraryItems',
                         ])
                         ->where('type', 'library_item')
                         ->whereHas('libraryItems.libraries', function ($query) {
                             $query->where('is_public', true);
                         })
                         ->get(),
        ]);
    }
}
