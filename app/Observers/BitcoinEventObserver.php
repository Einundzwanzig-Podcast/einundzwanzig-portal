<?php

namespace App\Observers;

use App\Models\BitcoinEvent;
use App\Traits\TwitterTrait;

class BitcoinEventObserver
{
    use TwitterTrait;

    /**
     * Handle the BitcoinEvent "created" event.
     */
    public function created(BitcoinEvent $bitcoinEvent): void
    {
        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            $text = sprintf("Ein neues Event wurde eingestellt:\n\n%s\n\n%s bis %s\n\n%s\n\n%s\n\n#Bitcoin #Event #Einundzwanzig #gesundesgeld",
                $bitcoinEvent->title,
                $bitcoinEvent->from->asDateTime(),
                $bitcoinEvent->to->asDateTime(),
                $bitcoinEvent->venue->name,
                $bitcoinEvent->link,
            );

            $this->postTweet($text);
        }
    }

    /**
     * Handle the BitcoinEvent "updated" event.
     */
    public function updated(BitcoinEvent $bitcoinEvent): void
    {
        //
    }

    /**
     * Handle the BitcoinEvent "deleted" event.
     */
    public function deleted(BitcoinEvent $bitcoinEvent): void
    {
        //
    }

    /**
     * Handle the BitcoinEvent "restored" event.
     */
    public function restored(BitcoinEvent $bitcoinEvent): void
    {
        //
    }

    /**
     * Handle the BitcoinEvent "force deleted" event.
     */
    public function forceDeleted(BitcoinEvent $bitcoinEvent): void
    {
        //
    }
}
