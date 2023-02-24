<?php

namespace App\Observers;

use App\Models\OrangePill;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class OrangePillObserver
{
    use NostrTrait;

    /**
     * Handle the OrangePill "created" event.
     */
    public function created(OrangePill $orangePill): void
    {
        try {
            $this->publishOnNostr($orangePill, $this->getText('OrangePill'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the OrangePill "updated" event.
     */
    public function updated(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "deleted" event.
     */
    public function deleted(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "restored" event.
     */
    public function restored(OrangePill $orangePill): void
    {
        //
    }

    /**
     * Handle the OrangePill "force deleted" event.
     */
    public function forceDeleted(OrangePill $orangePill): void
    {
        //
    }
}
