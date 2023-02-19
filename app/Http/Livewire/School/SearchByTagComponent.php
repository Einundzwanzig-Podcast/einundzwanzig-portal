<?php

namespace App\Http\Livewire\School;

use App\Models\Tag;
use Livewire\Component;

class SearchByTagComponent extends Component
{
    public string $country = 'de';

    public ?array $courses = [];

    protected $queryString = [
        'courses',
    ];

    public function render()
    {
        return view('livewire.school.search-by-tag-component', [
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
