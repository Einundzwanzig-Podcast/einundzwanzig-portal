<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Tag;
use Livewire\Component;

class SearchByTag extends Component
{
    public string $country = 'de';
    public ?array $table = [];

    protected $queryString = [
        'table',
    ];

    public function render()
    {
        return view('livewire.frontend.search-by-tag', [
            'tags' => Tag::query()
                         ->where('type', 'course')
                         ->with([
                             'courses.lecturer',
                         ])
                         ->withCount([
                             'courses',
                         ])
                         ->get(),
        ]);
    }
}
