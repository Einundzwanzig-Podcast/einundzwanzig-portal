<?php

namespace App\Observers;

use App\Models\MeetupEvent;
use App\Traits\NostrTrait;
use Exception;
use Illuminate\Support\Facades\Log;

class MeetupEventObserver
{
    use NostrTrait;

    /**
     * Handle the MeetupEvent "created" event.
     */
    public function created(MeetupEvent $meetupEvent): void
    {
        try {
            $this->publishOnNostr($meetupEvent, $this->getText('MeetupEvent'));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the MeetupEvent "updated" event.
     */
    public function updated(MeetupEvent $meetupEvent): void
    {
        //
    }

    /**
     * Handle the MeetupEvent "deleted" event.
     */
    public function deleted(MeetupEvent $meetupEvent): void
    {
        //
    }

    /**
     * Handle the MeetupEvent "restored" event.
     */
    public function restored(MeetupEvent $meetupEvent): void
    {
        //
    }

    /**
     * Handle the MeetupEvent "force deleted" event.
     */
    public function forceDeleted(MeetupEvent $meetupEvent): void
    {
        //
    }
}
