<?php

namespace App\Listeners;

use App\Events\PlebLoggedInEvent;
use App\Gamify\Points\LoggedIn;

class AddLoginReputation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $event->user->givePoint(new LoggedIn($event->user));
        event(new PlebLoggedInEvent($event->user->name, $event->user->profile_photo_url));
    }
}
