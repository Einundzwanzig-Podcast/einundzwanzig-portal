<?php

namespace App\Http\Livewire\News;

use App\Models\LibraryItem;
use App\Traits\TwitterTrait;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use WireUi\Traits\Actions;

class ArticleOverview extends Component
{
    use Actions;
    use TwitterTrait;

    public function tweet($id)
    {
        $libraryItem = LibraryItem::query()
                                  ->with([
                                      'lecturer',
                                  ])
                                  ->find($id);
        if ($libraryItem->tweet) {
            $this->notification()
                 ->error(__('Article already tweeted'));

            return;
        }
        $libraryItem->setStatus('published');
        $libraryItemName = $libraryItem->name;
        if ($libraryItem->lecturer->twitter_username && $libraryItem->type !== 'markdown_article') {
            $libraryItemName .= ' von @'.$libraryItem->lecturer->twitter_username;
        }
        if (! $libraryItem->lecturer->twitter_username) {
            $libraryItemName .= ' von '.$libraryItem->lecturer->name;
        }

        try {
            if (config('feeds.services.twitterAccountId')) {
                $this->setNewAccessToken(1);

                if (! $libraryItem->approved) {
                    $this->notification()
                         ->error(__('Article not approved yet'));

                    return;
                }

                $text = sprintf("Ein neuer News-Artikel wurde verfasst:\n\n%s\n\n%s\n\n#Bitcoin #News #Einundzwanzig #gesundesgeld",
                    $libraryItemName,
                    url()->route('article.view',
                        ['libraryItem' => $libraryItem->slug]),
                );

                $this->postTweet($text);

                $libraryItem->tweet = true;
                $libraryItem->save();

                $this->notification()
                     ->success(__('Article tweeted'));

                $this->emit('$refresh');
            }
        } catch (\Exception $e) {
            $this->notification()
                 ->error(__('Error tweeting article', $e->getMessage()));
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
            ),
        ]);
    }
}
