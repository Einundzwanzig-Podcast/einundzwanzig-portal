<?php

namespace App\Observers;

use App\Models\LibraryItem;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class LibraryItemObserver
{
    use NostrTrait;

    /**
     * Handle the LibraryItem "created" event.
     */
    public function created(LibraryItem $libraryItem): void
    {
        try {
            $libraryItem->setStatus('published');

            if (!$libraryItem->news) {
                if (
                    $libraryItem->type !== 'bindle'
                    && $libraryItem
                    ->whereDoesntHave('libraries',
                        fn($query) => $query->where('libraries.is_public', false))
                    ->exists()
                ) {
                    $this->publishOnNostr($libraryItem, $this->getText($libraryItem));
                }
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
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
