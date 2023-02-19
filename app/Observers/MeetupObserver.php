<?php

namespace App\Observers;

use App\Models\Meetup;
use App\Traits\TwitterTrait;
use Illuminate\Support\Facades\Log;

class MeetupObserver
{
    use TwitterTrait;

    /**
     * Handle the Meetup "created" event.
     *
     * @param  \App\Models\Meetup  $meetup
     * @return void
     */
    public function created(Meetup $meetup): void
    {
        try {
            if (config('feeds.services.twitterAccountId')) {
                $this->setNewAccessToken(1);

                $meetupName = $meetup->name;
                if ($meetup->twitter_username) {
                    $meetupName .= ' @'.$meetup->twitter_username;
                }

                $text = sprintf("Eine neue Meetup Gruppe wurde hinzugefügt:\n\n%s\n\n%s\n\n#Bitcoin #Meetup #Einundzwanzig #gesundesgeld",
                    $meetupName,
                    url()->route('meetup.landing', ['country' => $meetup->city->country->code, 'meetup' => $meetup])
                );

                $this->postTweet($text);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

    /**
     * Handle the Meetup "updated" event.
     *
     * @param  \App\Models\Meetup  $meetup
     * @return void
     */
    public function updated(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "deleted" event.
     *
     * @param  \App\Models\Meetup  $meetup
     * @return void
     */
    public function deleted(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "restored" event.
     *
     * @param  \App\Models\Meetup  $meetup
     * @return void
     */
    public function restored(Meetup $meetup): void
    {
        //
    }

    /**
     * Handle the Meetup "force deleted" event.
     *
     * @param  \App\Models\Meetup  $meetup
     * @return void
     */
    public function forceDeleted(Meetup $meetup): void
    {
        //
    }
}
