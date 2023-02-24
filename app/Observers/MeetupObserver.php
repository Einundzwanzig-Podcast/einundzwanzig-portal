<?php

namespace App\Observers;

use App\Models\Meetup;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class MeetupObserver
{
    use NostrTrait;

    /**
     * Handle the Meetup "created" event.
     */
    public function created(Meetup $meetup): void
    {
        try {
            $from = $meetup->name;
            if ($meetup->nostr) {
                $from .= ' @'.$meetup->nostr;
            }
            $this->publishOnNostr($meetup, $this->getText('Meetup', $from));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the Meetup "updated" event.
     */
    public function updated(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "deleted" event.
     */
    public function deleted(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "restored" event.
     */
    public function restored(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "force deleted" event.
     */
    public function forceDeleted(Meetup $meetup): void
    {
        //
    }
}
