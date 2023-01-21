<?php

namespace App\Observers;

use App\Models\LibraryItem;
use App\Traits\TwitterTrait;

class LibraryItemObserver
{
    use TwitterTrait;

    /**
     * Handle the LibraryItem "created" event.
     *
     * @param  \App\Models\LibraryItem  $libraryItem
     *
     * @return void
     */
    public function created(LibraryItem $libraryItem)
    {
        // todo: we can change this later
        $libraryItem->setStatus('published');

        $libraryItemName = $libraryItem->name;
        if ($libraryItem->lecturer->twitter_username && $libraryItem->type !== 'markdown_article') {
            $libraryItemName .= ' von @'.$libraryItem->lecturer->twitter_username;
        }
        if ($libraryItem->lecturer->twitter_username && $libraryItem->type === 'markdown_article') {
            $libraryItemName .= ' von '.$libraryItem->lecturer->name;
        }

        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            // http://localhost/de/library/library-item?l=de&table[filters][id]=2

            if ($libraryItem->type !== 'markdown_article') {
                $text = sprintf("Es gibt was Neues zum Lesen oder Anhören:\n\n%s\n\n%s\n\n#Bitcoin #Wissen #Einundzwanzig #gesundesgeld",
                    $libraryItemName,
                    url()->route('article.view',
                        ['libraryItem' => $libraryItem->slug]),
                );

                $this->postTweet($text);
            } else {
                $text = sprintf("Ein neuer News-Artikel wurde verfasst:\n\n%s\n\n%s\n\n#Bitcoin #News #Einundzwanzig #gesundesgeld",
                    $libraryItemName,
                    url()->route('article.view',
                        ['libraryItem' => $libraryItem->slug]),
                );

                //$this->postTweet($text);
            }
        }
    }

    /**
     * Handle the LibraryItem "updated" event.
     *
     * @param  \App\Models\LibraryItem  $libraryItem
     *
     * @return void
     */
    public function updated(LibraryItem $libraryItem)
    {
        //
    }

    /**
     * Handle the LibraryItem "deleted" event.
     *
     * @param  \App\Models\LibraryItem  $libraryItem
     *
     * @return void
     */
    public function deleted(LibraryItem $libraryItem)
    {
        //
    }

    /**
     * Handle the LibraryItem "restored" event.
     *
     * @param  \App\Models\LibraryItem  $libraryItem
     *
     * @return void
     */
    public function restored(LibraryItem $libraryItem)
    {
        //
    }

    /**
     * Handle the LibraryItem "force deleted" event.
     *
     * @param  \App\Models\LibraryItem  $libraryItem
     *
     * @return void
     */
    public function forceDeleted(LibraryItem $libraryItem)
    {
        //
    }
}
