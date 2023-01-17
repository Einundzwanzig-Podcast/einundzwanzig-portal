<?php

namespace App\Observers;

use App\Models\BitcoinEvent;
use App\Traits\TwitterTrait;

class BitcoinEventObserver
{
    use TwitterTrait;

    /**
     * Handle the BitcoinEvent "created" event.
     *
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return void
     */
    public function created(BitcoinEvent $bitcoinEvent)
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
     *
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return void
     */
    public function updated(BitcoinEvent $bitcoinEvent)
    {
        //
    }

    /**
     * Handle the BitcoinEvent "deleted" event.
     *
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return void
     */
    public function deleted(BitcoinEvent $bitcoinEvent)
    {
        //
    }

    /**
     * Handle the BitcoinEvent "restored" event.
     *
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return void
     */
    public function restored(BitcoinEvent $bitcoinEvent)
    {
        //
    }

    /**
     * Handle the BitcoinEvent "force deleted" event.
     *
     * @param  \App\Models\BitcoinEvent  $bitcoinEvent
     *
     * @return void
     */
    public function forceDeleted(BitcoinEvent $bitcoinEvent)
    {
        //
    }
}
