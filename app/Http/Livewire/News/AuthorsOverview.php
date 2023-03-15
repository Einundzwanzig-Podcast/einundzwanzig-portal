<?php

namespace App\Http\Livewire\News;

use App\Models\Lecturer;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

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
                                 ->orderByDesc('library_items_count')
                                 ->get(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('News articles writer'),
                description: __('Click on any of the authors to see their articles.'),
                image: asset('img/einundzwanzig-news-colored.png'),
            ),
        ]);
    }
}
