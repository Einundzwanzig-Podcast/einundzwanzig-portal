<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use Carbon\Carbon;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class InternArticleView extends Component
{
    public LibraryItem $libraryItem;

    public function mount()
    {
        $this->libraryItem->load([
            'libraries',
        ]);
        if ($this->libraryItem->libraries->where('is_public', false)
                                         ->count() > 0 && ! auth()->check()) {
            abort(403, __('Sorry! You are not authorized to perform this action.'));
        }
    }

    public function render()
    {
        if ($this->libraryItem->type === 'markdown_article') {
            $description = $this->libraryItem->excerpt ?? __('An entry in the library of Einundzwanzig.');
        } else {
            $description = $this->libraryItem->excerpt ?? __('Here we post important news that is relevant for everyone.');
        }

        return view('livewire.news.intern-article-view')->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: $this->libraryItem->name,
                description: strip_tags($this->libraryItem->excerpt) ?? __('Here we post important news that is relevant for everyone.'),
                author: $this->libraryItem->lecturer->name,
                image: $this->libraryItem->getFirstMedia('main') ? $this->libraryItem->getFirstMediaUrl('main') : asset('img/einundzwanzig-wallpaper-benrath.png'),
                published_time: Carbon::parse($this->libraryItem->created_at),
                type: 'article',
            ),
        ]);
    }
}
