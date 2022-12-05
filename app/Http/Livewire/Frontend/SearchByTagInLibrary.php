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
                         ->where('type', 'library_item')
                         ->get(),
        ]);
    }
}
