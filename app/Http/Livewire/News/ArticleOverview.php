<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use App\Traits\HasTextToSpeech;
use App\Traits\NostrTrait;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use WireUi\Traits\Actions;

class ArticleOverview extends Component
{
    use Actions;
    use NostrTrait;
    use HasTextToSpeech;

    public $perPage = 9;

    public array $filters = [];

    protected $queryString = [
        'filters' => ['except' => ''],
    ];

    public function loadMore()
    {
        $this->perPage += 9;
    }

    public function nostr($id)
    {
        $libraryItem = LibraryItem::query()
                                  ->with([
                                      'lecturer',
                                  ])
                                  ->find($id);
        $libraryItem->setStatus('published');
        $libraryItemName = $libraryItem->name;
        if ($libraryItem->lecturer->nostr) {
            $libraryItemName .= ' von @'.$libraryItem->lecturer->nostr;
        } else {
            $libraryItemName .= ' von '.$libraryItem->lecturer->name;
        }
        $text = sprintf("Ein neuer News-Artikel wurde verfasst:\n\n%s\n\n%s\n\n#Bitcoin #News #Einundzwanzig #gesundesgeld #einundzwanzig_portal_%s",
            $libraryItemName,
            url()->route('article.view',
                ['libraryItem' => $libraryItem->slug]),
            str($libraryItem->slug)->replace('-', '_')
        );
        $result = $this->publishOnNostr($libraryItem, $text);
        if ($result['success']) {
            $this->notification()
                 ->success(title: __('Published on Nostr'), description: $result['output']);
        } else {
            $this->notification()
                 ->error(title: __('Failed'),
                     description: 'Exit Code: '.$result['exitCode'].' Reason: '.$result['errorOutput']);
        }
    }

    public function approve($id)
    {
        $libraryItem = LibraryItem::find($id);
        $libraryItem->approved = true;
        $libraryItem->save();

        $this->notification()
             ->success(__('Article approved'));

        $this->emit('$refresh');
    }

    public function resetFiltering()
    {
        return to_route('article.overview');
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
                                         ->when(
                                             isset($this->filters['author']),
                                             fn($query) => $query->whereHas('lecturer',
                                                 fn($query) => $query->where('lecturers.slug',
                                                     $this->filters['author'])))
                                         ->where('type', 'markdown_article')
                                         ->where('news', true)
                                         ->orderByDesc('created_at')
                                         ->paginate($this->perPage),
        ])->layout('layouts.app', [
            'SEOData' => new SEOData(
                title: __('News'),
                description: __('Here we post important news that is relevant for everyone.'),
                image: asset('img/einundzwanzig-news-colored.png'),
            ),
        ]);
    }
}
