<?php

namespace App\Observers;

use App\Models\BitcoinEvent;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class BitcoinEventObserver
{
    use NostrTrait;

    /**
     * Handle the BitcoinEvent "created" event.
     */
    public function created(BitcoinEvent $bitcoinEvent): void
    {
        try {
            $this->publishOnNostr($bitcoinEvent, $this->getText($bitcoinEvent));
        } catch (Exception $e) {
            Log::error($e->getMessage());
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
