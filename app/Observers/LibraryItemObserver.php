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
        if ($libraryItem->lecturer->twitter_username) {
            $libraryItemName .= ' von @'.$libraryItem->lecturer->twitter_username;
        }

        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            // http://localhost/de/library/library-item?l=de&table[filters][id]=2

            $text = sprintf("Es gibt was Neues zum Anschauen oder Anhören:\n\n%s\n\n%s\n\n#Bitcoin #Event #Einundzwanzig #gesundesgeld",
                $libraryItemName,
                url()->route('library.table.libraryItems',
                    ['country' => 'de', 'table' => ['filters' => ['id' => $libraryItem->id]]]),
            );

            $this->postTweet($text);
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
