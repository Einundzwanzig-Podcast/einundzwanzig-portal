<?php

namespace App\Observers;

use App\Models\MeetupEvent;
use App\Traits\TwitterTrait;

class MeetupEventObserver
{
    use TwitterTrait;

    /**
     * Handle the MeetupEvent "created" event.
     *
     * @param  \App\Models\MeetupEvent  $meetupEvent
     *
     * @return void
     */
    public function created(MeetupEvent $meetupEvent)
    {
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
                    ['country' => 'de', 'meetup' => $meetupEvent->id]),
            );

            $this->postTweet($text);
        }
    }

    /**
     * Handle the MeetupEvent "updated" event.
     *
     * @param  \App\Models\MeetupEvent  $meetupEvent
     *
     * @return void
     */
    public function updated(MeetupEvent $meetupEvent)
    {
        //
    }

    /**
     * Handle the MeetupEvent "deleted" event.
     *
     * @param  \App\Models\MeetupEvent  $meetupEvent
     *
     * @return void
     */
    public function deleted(MeetupEvent $meetupEvent)
    {
        //
    }

    /**
     * Handle the MeetupEvent "restored" event.
     *
     * @param  \App\Models\MeetupEvent  $meetupEvent
     *
     * @return void
     */
    public function restored(MeetupEvent $meetupEvent)
    {
        //
    }

    /**
     * Handle the MeetupEvent "force deleted" event.
     *
     * @param  \App\Models\MeetupEvent  $meetupEvent
     *
     * @return void
     */
    public function forceDeleted(MeetupEvent $meetupEvent)
    {
        //
    }
}
