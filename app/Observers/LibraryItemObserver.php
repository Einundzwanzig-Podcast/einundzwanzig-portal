<?php

namespace App\Observers;

use App\Models\LibraryItem;
use App\Traits\TwitterTrait;

class LibraryItemObserver
{
    use TwitterTrait;

    /**
     * Handle the LibraryItem "created" event.
     */
    public function created(LibraryItem $libraryItem): void
    {
        // todo: we can change this later
        try {
            $libraryItem->setStatus('published');

            $libraryItemName = $libraryItem->name;
            if ($libraryItem->lecturer->twitter_username && $libraryItem->type !== 'markdown_article') {
                $libraryItemName .= ' von @'.$libraryItem->lecturer->twitter_username;
            }
            if (! $libraryItem->lecturer->twitter_username) {
                $libraryItemName .= ' von '.$libraryItem->lecturer->name;
            }

            if (config('feeds.services.twitterAccountId')) {
                $this->setNewAccessToken(1);

                // http://localhost/de/library/library-item?l=de&table[filters][id]=2

                if ($libraryItem->type !== 'markdown_article') {
                    if ($libraryItem->whereDoesntHave('libraries',
                        fn ($query) => $query->where('libraries.is_public', false))
                                    ->exists()) {
                        $text = sprintf("Es gibt was Neues zum Lesen oder Anhören:\n\n%s\n\n%s\n\n#Bitcoin #Wissen #Einundzwanzig #gesundesgeld",
                            $libraryItemName,
                            url()->route('article.view',
                                ['libraryItem' => $libraryItem->slug]),
                        );
                        $this->postTweet($text);
                    }
                }
            }
        } catch (\Exception $e) {
            // todo: log this
        }
    }

    /**
     * Handle the LibraryItem "updated" event.
     */
    public function updated(LibraryItem $libraryItem): void
    {
        //
    }

    /**
     * Handle the LibraryItem "deleted" event.
     */
    public function deleted(LibraryItem $libraryItem): void
    {
        //
    }

    /**
     * Handle the LibraryItem "restored" event.
     */
    public function restored(LibraryItem $libraryItem): void
    {
        //
    }

    /**
     * Handle the LibraryItem "force deleted" event.
     */
    public function forceDeleted(LibraryItem $libraryItem): void
    {
        //
    }
}
