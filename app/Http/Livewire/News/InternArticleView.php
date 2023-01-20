<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use Carbon\Carbon;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class InternArticleView extends Component
{
    public LibraryItem $libraryItem;

    public function render()
    {
        return view('livewire.news.intern-article-view')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: $this->libraryItem->name,
                description: $this->libraryItem->excerpt ?? __('Here we post important news that is relevant for everyone.'),
                author: $this->libraryItem->lecturer->name,
                image: asset('img/einundzwanzig-wallpaper-benrath.png'),
                published_time: Carbon::parse($this->libraryItem->created_at),
                type: 'article',
            )
        ]);
    }
}
