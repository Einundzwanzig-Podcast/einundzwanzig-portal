<?php

namespace App\Observers;

use App\Models\LibraryItem;

class LibraryItemObserver
{
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

        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            // http://localhost/de/library/library-item?l=de&table[filters][id]=2

            $text = sprintf("Es gibt was Neues zum Anschauen oder Hören:\n\n%s\n\n%s\n\n#Bitcoin #Event #Einundzwanzig #gesundesgeld",
                $libraryItem->name,
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
