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
            $meetupName = $meetup->name;
            if ($meetup->nostr) {
                $meetupName .= ' @'.$meetup->nostr;
            }
            $text = sprintf("Eine neue Meetup Gruppe wurde hinzugefügt:\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                $meetupName,
                url()->route('meetup.landing', ['country' => $meetup->city->country->code, 'meetup' => $meetup])
            );
            $this->publishOnNostr($meetup, $text);
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
