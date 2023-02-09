<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class ArticleOverview extends Component
{
    public function render()
    {
        return view('livewire.news.article-overview', [
            'libraryItems' => LibraryItem::query()
                                         ->with([
                                             'createdBy.roles',
                                             'lecturer',
                                             'tags',
                                         ])
                                         ->where('type', 'markdown_article')
                                         ->when(app()->environment('production'),
                                             fn($query) => $query
                                                 ->whereHas('createdBy.roles',
                                                     fn($query) => $query->where('roles.name', 'news-editor'))
                                         )
                                         ->where('approved', true)
                                         ->orderByDesc('created_at')
                                         ->get(),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('News'),
                description: __('Here we post important news that is relevant for everyone.'),
                image: asset('img/einundzwanzig-news-colored.png'),
            )
        ]);
    }
}
