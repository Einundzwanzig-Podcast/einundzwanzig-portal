<?php

namespace App\Http\Livewire\News;

use App\Models\Lecturer;
use Livewire\Component;

class AuthorsOverview extends Component
{
    public function render()
    {
        return view('livewire.news.authors-overview', [
            'authors' => Lecturer::query()
                                 ->whereHas('libraryItems', function ($query) {
                                     $query->where('library_items.news', true);
                                 })
                                 ->withCount([
                                     'libraryItems' => fn($query) => $query->where('library_items.news', true),
                                 ])
                                 ->get(),
        ]);
    }
}
