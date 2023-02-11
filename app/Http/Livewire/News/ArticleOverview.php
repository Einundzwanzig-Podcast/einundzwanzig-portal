<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use WireUi\Traits\Actions;

class ArticleOverview extends Component
{
    use Actions;

    public function approve($id)
    {
        $libraryItem = LibraryItem::find($id);
        $libraryItem->approved = true;
        $libraryItem->save();

        $this->notification()
             ->success(__('Article approved'));

        $this->emit('$reload');
    }

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
                                         ->where('news', true)
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
