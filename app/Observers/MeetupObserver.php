<?php

namespace App\Observers;

use App\Models\Meetup;
use App\Traits\TwitterTrait;

class MeetupObserver
{
    use TwitterTrait;

    /**
     * Handle the Meetup "created" event.
     *
     * @param  \App\Models\Meetup  $meetup
     *
     * @return void
     */
    public function created(Meetup $meetup)
    {
        if (config('feeds.services.twitterAccountId')) {
            $this->setNewAccessToken(1);

            $text = sprintf("Eine neue Meetup Gruppe wurde hinzugefügt:\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig",
                $meetup->name,
                url()->route('meetup.landing', ['country' => 'de', 'meetup' => $meetup])
            );

            $this->postTweet($text);
        }
    }

    /**
     * Handle the Meetup "updated" event.
     *
     * @param  \App\Models\Meetup  $meetup
     *
     * @return void
     */
    public function updated(Meetup $meetup)
    {
        //
    }

    /**
     * Handle the Meetup "deleted" event.
     *
     * @param  \App\Models\Meetup  $meetup
     *
     * @return void
     */
    public function deleted(Meetup $meetup)
    {
        //
    }

    /**
     * Handle the Meetup "restored" event.
     *
     * @param  \App\Models\Meetup  $meetup
     *
     * @return void
     */
    public function restored(Meetup $meetup)
    {
        //
    }

    /**
     * Handle the Meetup "force deleted" event.
     *
     * @param  \App\Models\Meetup  $meetup
     *
     * @return void
     */
    public function forceDeleted(Meetup $meetup)
    {
        //
    }
}
