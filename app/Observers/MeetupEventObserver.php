<?php

namespace App\Observers;

use App\Models\MeetupEvent;
use App\Traits\TwitterTrait;
use Illuminate\Support\Facades\Log;

class MeetupEventObserver
{
    use TwitterTrait;

    /**
     * Handle the MeetupEvent "created" event.
     */
    public function created(MeetupEvent $meetupEvent): void
    {
        try {
            if (config('feeds.services.twitterAccountId')) {
                $this->setNewAccessToken(1);

                $meetupName = $meetupEvent->meetup->name;
                if ($meetupEvent->meetup->twitter_username) {
                    $meetupName .= ' @'.$meetupEvent->meetup->twitter_username;
                }

                $text = sprintf("%s hat einen neuen Termin eingestellt:\n\n%s\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                    $meetupName,
                    $meetupEvent->start->asDateTime(),
                    $meetupEvent->location,
                    url()->route('meetup.event.landing',
                        ['country' => 'de', 'meetupEvent' => $meetupEvent->id]),
                );

                $this->postTweet($text);
            }
        } catch (\Exception $e) {
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
