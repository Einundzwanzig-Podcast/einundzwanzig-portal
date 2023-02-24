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
            $meetupName = $meetupEvent->meetup->name;
            if ($meetupEvent->meetup->nostr) {
                $meetupName .= ' @'.$meetupEvent->meetup->nostr;
            }
            $text = sprintf("%s hat einen neuen Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $meetupName,
                $meetupEvent->start->asDateTime(),
                $meetupEvent->location,
                url()->route('meetup.event.landing',
                    ['country' => 'de', 'meetupEvent' => $meetupEvent->id]),
            );
            $this->publishOnNostr($meetupEvent, $text);
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
